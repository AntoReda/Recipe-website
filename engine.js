// The calculator pane div element. Do not modify its innerText or innerContent as that will remove the LHS & RHS spans
const result = document.getElementById('result')

// Holds either the user input or the calculation result
const resultLHS = document.getElementById('input')

// Holds temporary unclosed parentheses from the LHS to ensure balanced parentheses at all times
const resultRHS = document.getElementById('unclosed-parentheses')

const E = 2.718281828459045
const BASE_10_CONV = 2.302585092994
const PI = 3.141592653589793

const GAMMA = String.fromCharCode(915)
const SQRT = String.fromCharCode(8730)
const DIVIDE = String.fromCharCode(247)
const TIMES = String.fromCharCode(215)

// Keeps track of whether an error alert has already been displayed for the current result to avoid double alert
let alertFired = false

//Assigns hotkeys so the user can use their keyboard to input their calculations.
const hotkeyMap = {
  '+': '+',
  '-': '-',
  '*': TIMES,
  x: TIMES,
  TIMES: TIMES,
  '/': DIVIDE,
  DIVIDE: DIVIDE,
  '(': '(',
  ')': ')',
  '.': '.',
  '^': '^(',
  '%': '%',
  '0': '0',
  '1': '1',
  '2': '2',
  '3': '3',
  '4': '4',
  '5': '5',
  '6': '6',
  '7': '7',
  '8': '8',
  '9': '9',
  a: 'arccos(',
  g: `${GAMMA}(`,
  GAMMA: `${GAMMA}(`,
  l: `log(`,
  r: `${SQRT}(`,
  SQRT: `${SQRT}(`,
  s: 'sinh('
}

document.onkeydown = (event) => {
  const key = event.key
  const focusedElement = document.activeElement

  if (key in hotkeyMap) {
    handleInput(key)
  } else if (key === '=' || (key === 'Enter' && focusedElement.tagName.toLowerCase() !== 'button')) {
    Equals()
  } else if (key === 'Delete' || key === 'c') {
    Clear()
  } else if (key === 'Backspace') {
    Delete()
  }
}

// Attach event listener to handle calculator input button clicks
document.onclick = (event) => {
  const target = event.target

  if (target.className === ('input-btn')) {
    const key = Object.keys(hotkeyMap).find(key => hotkeyMap[key].includes(event.target.innerHTML))
    handleInput(key)

  }

  // Remove focus from calculator button, s.t. 'Enter' key computes result instead of repeating last clicked button
  if (target.parentElement && target.parentElement.parentElement   // Avoid null error
    && target.parentElement.parentElement.id === 'calc-buttons') {
    target.blur()
  }
}

/**
 * Validates the key and either rejects or appends its corresponding entry with any needed modifications
 * @param key - The last calculator hotkey triggered (printable keys only) */
function handleInput (key) {

  const lastChar = resultLHS.textContent.slice(-1)
  let textLHS = resultLHS.textContent
  let entry = ''

  if (textLHS.includes('Infinity') || textLHS === 'NaN' || textLHS === 'undefined') {
    Clear()
    textLHS = resultLHS.textContent
  }

  // Add parenthesis before minus where needed
  if (key === '-' && /[+\u00F7\u00D7-]/.test(lastChar)) {
    entry = '(-'
  }
  // Add 0 (and possibly multiplication sign) before dot where needed
  else if (key === '.' && /([^.\d])|(^$)/.test(lastChar)) {
    entry = /[)%]/.test(lastChar) ? TIMES + '0.' : '0.'
  }
  // Add multiplication sign before '(' or function, or after ')' or '%' where needed
  else if (/[a-w(\u0393\u221A]/.test(key) && /[).\d]/.test(lastChar)
    || (/[\da-w(.\u0393\u221A]/.test(key) && (lastChar === ')' || lastChar === '%'))) {
    entry = TIMES + hotkeyMap[key]
  } else if ((/[^\u00F7/*x\u00D7%)^+]/.test(key) || lastChar !== '' && lastChar !== '(')// Reject starting *,/,%,),^
    && (/[^+\u00F7/*x\u00D7)%^]/.test(key) || /[^+\u00F7\u00D7-]/.test(lastChar))   // Reject invalid op. combos
    && (key !== '.' || !/\.\d*$/.test(textLHS))                                     // Reject double dots in one num
    && (key !== ')' || resultRHS.textContent)) {                                    // Reject unbalanced parentheses
    entry = hotkeyMap[key]                                                         // Accept everything else as is
  }

  //adds a closing parenthesis if you did not close it yourself.
  if (entry.includes('(')) {
    resultRHS.textContent += ')'
  }
  if (entry === ')') {
    popParenthesisRHS()
  }

  resultLHS.textContent += entry
  result.scrollLeft = result.scrollWidth
}

const histList = document.getElementById('historyList')

function calcHistory () {
  if (histList.style.display !== 'block') {
    histList.style.display = 'block'
    // Load the previous data from localStorage
    const previousData = JSON.parse(localStorage.getItem('calculator_history')) || []
    // Display the previous data in the history list
    for (let i = 0; i < previousData.length; i++) {
      const r = previousData[i]
      const listItem = document.createElement('button')
      listItem.id = 'histBtn'
      listItem.textContent = r
      histList.appendChild(listItem)
      // Add a click event listener to the list item
      listItem.addEventListener('click', () => {
        resultLHS.textContent = r
      })
    }
  } else {
    histList.style.display = 'none'
    // Remove all the list items from the DOM
    while (histList.lastChild.id == 'histBtn') {
      histList.removeChild(histList.lastChild)
    }
  }

}

//This function removes all the contents from the input.
function Clear () {
  resultLHS.textContent = ''
  resultRHS.textContent = ''
}

//This function removes one element at a time from the input.
function Delete () {
  const textLHS = resultLHS.textContent

  if (textLHS === '') {
    return
  } else if (textLHS.includes('Infinity') || textLHS === 'NaN' || textLHS === 'undefined') {
    Clear()
    return
  }

  // Remove last input as a block if it corresponds to a function with more than one char. e.g. log(, sinh(, etc
  const mathFns = Object.values(hotkeyMap).filter(input => input.length > 1)
  const lastFn = mathFns.find(input => textLHS.endsWith(input))

  if (lastFn) {
    popParenthesisRHS()
    resultLHS.textContent = textLHS.slice(0, -lastFn.length)
  } else if (resultLHS.textContent.endsWith('(')) {
    popParenthesisRHS()
    resultLHS.textContent = textLHS.slice(0, -1)
  } else {
    resultLHS.textContent = textLHS.slice(0, -1)
  }
}

function popParenthesisRHS () {
  let parentheses = resultRHS.textContent
  resultRHS.textContent = parentheses.substring(0, parentheses.length - 1)
}

//Function to Evaluate the math expressions.
function Equals () {
  let expression = result.textContent.replaceAll(/\s/g, '')

  if (!expression || expression.includes('Infinity') || expression === 'undefined' || expression === 'NaN') {
    return
  }

  expression = expression.replaceAll(TIMES, '*')
  expression = expression.replaceAll(DIVIDE, '/')
  expression = expression.replaceAll(GAMMA, 'gamma')
  expression = expression.replaceAll(SQRT, 'sqrt')
  expression = expression.replaceAll('%', '/100')
  expression = convertPowerExpressions(expression)

  let answer = eval(expression)
  answer = (answer === undefined) ? 'undefined' : answer.toString()

  result.scrollLeft = 0
  resultRHS.textContent = ''
  resultLHS.textContent = answer
  saveResult(answer)

  //Error messages for numbers that are too high or illegal operation.
  if (answer === 'Infinity') {
    errorAlert('DIVIDE BY ZERO', 'The denominator of an expression cannot be equal to 0', 'Ensure that the denominator of the expression does not evaluate to 0')
  } else if (answer === 'undefined' || answer === 'NaN') {
    errorAlert('INVALID INPUT', 'The result of this expression cannot be evaluated', 'Ensure that you are performing a legal evaluation')
  }

  alertFired = false

  // Converts all power expressions from calculator format to function call (e.g. 5^(6) to power(5,6))
  function convertPowerExpressions (expression) {
    let powerExpressions = expression.matchAll(/(?![-+*\/])(.+?)\^\((.+?)\)/g)

    for (const matchGroups of powerExpressions) {
      let powerExpression = matchGroups[0]
      let base = matchGroups[1]
      let exponent = matchGroups[2]

      expression = expression.replace(powerExpression, 'power(' + base + ',' + exponent + ')')
    }

    return expression
  }
}

function saveResult (toSave) {
  const MAX_HISTORY_LENGTH = 10
  // Load the previous data from localStorage
  const previousData = JSON.parse(localStorage.getItem('calculator_history')) || []
  // Add the result to the previous data
  previousData.unshift(toSave)
  // Remove the oldest entry if the maximum history length has been reached
  if (previousData.length > MAX_HISTORY_LENGTH) {
    previousData.pop()
  }
  // Save the updated data back to localStorage
  localStorage.setItem('calculator_history', JSON.stringify(previousData))
}

function errorAlert (error, explanation, solution) {
  if (!alertFired) {
    alert(`Error: ${error}.\nExplanation: ${explanation}.\nSolution: ${solution}.`)
    alertFired = true
  }
}