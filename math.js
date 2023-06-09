//this function is meant to calculate the standard deviation of the array "num"
function std () {
  var mean = 0
  let num = getNumArray()

  // Cancel calculation if user canceled prompt
  if (num === null) {
    return
  }

  for (var i = 0; i < num.length; i++) {
    mean = Number(mean) + Number(num[i])
  }

  const n = num.length
  mean = mean / n

  var sumSquareDif = 0
  for (var i = 0; i < num.length; i++) {
    sumSquareDif = Number(sumSquareDif) + Number(power(Number(num[i]) - mean, 2))
  }
  var mean2 = sumSquareDif / n
  var stdDev = sqrt(mean2)

  resultLHS.textContent = stdDev
  saveResult(resultLHS.textContent)
}

//Function to calculate the Mean Absolute Deviation
function mad () {

  let num = getNumArray()

  //Cancel calculation if user canceled prompt
  if (num === null) {
    return
  }

  let sum = 0
  const n = num.length

  //Calculate the mean of the array
  for (let i = 0; i < n; i++) {
    sum += parseInt(num[i])
  }
  const mean = sum / n

  //Calculate the absolute deviation of each element from the mean
  let deviationSum = 0
  for (let i = 0; i < n; i++) {
    const deviation = num[i] - mean
    deviationSum += deviation < 0 ? -deviation : deviation //Gets the absolute value
  }
  const mad = deviationSum / n

  resultLHS.textContent = mad
  saveResult(mad)

}

function log (x) {
  if (x <= 0) {
    result.value = 'undefined'
    return
  }
  const ITER = 20
  // Check for invalid input
  if (x <= 0) {
    //Error handling
  }

  // Bring x to a reasonable range
  let pow = 0
  while (x > 1.0) {
    x /= E
    pow++
  }
  while (x < .25) {
    x *= E
    pow--
  }

  // Uses the Taylor series to calculate the logarithm of base e
  x -= 1.0
  let t = 0.0, s = 1.0, z = x
  for (let k = 1; k <= ITER; k++) {
    t += z * s / k
    z *= x
    s = -s
  }

  // Combine the result with the power adjustment value
  t += pow
  //Convert to base 10
  return t / BASE_10_CONV
}

function ln (x) {
  return log(x) / log(E)
}

// Prompts user for comma-separated list of valid numbers, returns array of said numbers or null if the user cancels
function getNumArray () {
  let input = window.prompt('Input the elements separated by commas.')
  let nums = (input === null) ? null : input.split(',').filter(i => i !== '').map(Number)

  // Prompt again if invalid numbers or no numbers were input
  while (nums !== null && (nums.includes(NaN) || nums.includes(Infinity) || nums.includes(-Infinity) || nums.length === 0)) {
    if (nums.length === 0) {
      input = window.prompt('You did not input any numbers. Try again.')
    } else {
      input = window.prompt('Your input "' + input + '" was invalid. Your input should be a comma-separated list of numbers. Try again.')
    }

    nums = (input === null) ? null : input.split(',').filter(i => i !== '').map(Number)
  }

  return nums
}

function power (base, exponent) {
  let answer

  if (exponent == 0) {
    return 1
  }
  if (base === 0) {
    return 0
  }
  // Provide near perfect precision in case of integer exponents that aren't too large to compute
  else if (exponent % 1 === 0 && exponent < 1000000) {
    answer = base

    for (let i = 1; i < abs(exponent); i++) {
      answer *= base
    }

    answer = (exponent < 0) ? (1 / answer) : (answer)
  }
  // Provide approximation in case of non-integer exponents, or overly large exponents
  else {
    answer = exp(exponent * ln(abs(base)))
    answer = (base < 0 && exponent % 2 === 1) ? -answer : answer
  }

  if (answer === Infinity) {
    errorAlert('POWER FUNCTION ERROR', `The result of computing ${base}^(${exponent}) is too large 
        to represent as a number`, 'Try a smaller input value')
  }

  return answer
}

function abs (x) {
  return (x < 0) ? -x : x
}

// Calculation uses the Lanczos approximation method. This function is undefined for non-positive integers.
function gamma (z) {
  if (z % 1 !== 0) {
    const G = 8, COEFF = [0.9999999999999999298,
      1975.3739023578852322,
      -4397.3823927922428918,
      3462.6328459862717019,
      -1156.9851431631167820,
      154.53815050252775060,
      -6.2536716123689161798,
      0.034642762454736807441,
      -7.4776171974442977377e-7,
      6.3041253821852264261e-8,
      -2.7405717035683877489e-8,
      4.0486948817567609101e-9
    ]

    if (z < 0.5) {
      // Reflection formula for negative base
      return PI / (sin(PI * z, false) * gamma(1 - z))
    }

    z -= 1
    let a = COEFF[0]
    let t = z + G + 0.5

    for (let i = 1; i < COEFF.length; i++) {
      a += COEFF[i] / (z + i)
    }

    let answer = sqrt(2 * PI) * power(t, z + 0.5) * exp(-t) * a

    if (answer === Infinity || answer === -Infinity) {
      errorAlert('GAMMA ERROR', ' The result of computing ' + String.fromCharCode(915) +
        '(' + ++z + ') is too large to represent as a number', 'Try a smaller input value')
    }

    return answer
  } else if (z > 0) {
    return factorial(z - 1)
  } else {
    errorAlert('GAMMA ERROR', 'You tried to compute ' + String.fromCharCode(915) +
      '(' + z + '). The Gamma function is undefined for non-positive integers', 'Try again')
  }
}

function factorial (n) {
  let answer = 1

  for (let m = 2; m <= n; m++) {
    answer *= m
  }

  if (answer === Infinity) {
    errorAlert('GAMMA ERROR', 'The result of computing ' + String.fromCharCode(915) +
      '(' + ++n + ') is too large to represent as a number', 'Try a smaller input value')
  }

  return answer
}

/**
 * @param {number} x - A number in radians
 * @returns {number} - The sine of the given number, at 14 decimals precision
 */
function sin (x) {

  // Reduce x to within the range [-pi, pi] to improve accuracy
  x = x % (2 * Math.PI)
  if (x > Math.PI) {
    x -= 2 * Math.PI
  } else if (x < -Math.PI) {
    x += 2 * Math.PI
  }

  let answer = 0
  let term = x

  // Taylor series expansion; accuracy gained above 15 iterations is highly negligible
  for (let n = 1; n <= 15; n++) {
    answer += term
    term = power(-1, n) * power(x, 2 * n + 1) / factorial(2 * n + 1)
  }

  return answer
}

function sinh (x) {
  return (exp(x) - exp(-x)) / 2
}

function myASIN2 (x) {
  let sum, tempExp
  tempExp = x
  let factor = 1.0
  let divisor = 1.0
  sum = x
  for (let i = 0; i < 50; i++) // Increased the number of iterations
  {
    tempExp *= x * x
    divisor += 2.0
    factor *= (2.0 * i + 1.0) / (((i) + 1.0) * 2.0)
    sum += factor * tempExp / divisor
  }
  return sum
}

function myASIN (x) {
  let tmp = (1.0 - (x * x))
  if (tmp < 0) {
    errorAlert('ARCCOS ERROR', 'Input value is out of range: [-1, 1]', 'Use an input value between -1 and 1')
    return
  }
  if (abs(x) <= 0.71) // Replaced abs() with Math.abs()
    return myASIN2(x)
  else if (x > 0)
    return (PI / 2.0 - myASIN2(sqrt(tmp))) // Replaced calculateSqrt() with Math.sqrt()
  else if (isNaN(x)) // Added a check for NaN inputs
    return NaN
  else // x < 0
    return (myASIN2(sqrt(tmp)) - PI / 2.0)
}

function arccos (x) {
  if (!isNaN(x)) {
    let arccosine = PI / 2.0 - myASIN(x)
    return arccosine
  }
}

function exp (x) {
  let answer = 1
  let term = 1

  // Taylor series expansion
  for (let i = 1; i < 100; i++) {
    term *= x / i
    answer += term
  }

  return answer
}

function sqrt (x) {
  function square (n, i, j, iterations) {
    let mid = (i + j) / 2
    let mul = mid * mid
    var numAprox = mul - n
    var tempTextAprox
    tempTextAprox = numAprox.toString(10)
    //Handles negative sqrt in the internal function.
    if (tempTextAprox.includes('-')) {
      tempTextAprox.replace(/-/, '')
    }
    const absoluteValue = Number(tempTextAprox)
    if ((mul === n) || (absoluteValue.value < 0.00000001) || (iterations >= 1000)) {
      return mid
    } else if (mul < n) {
      return square(n, mid, j, iterations + 1)
    } else {
      return square(n, i, mid, iterations + 1)
    }
  }

  const findSqrt = num => {
    var textAprox
    textAprox = num.toString(10)
    //Handles inputs of -0.
    if (textAprox == '-0' || textAprox == '0') {
      return 0
    }
    //Error message for negative sqrt
    num = Number(textAprox)
    if (num < 0) {
      errorAlert('SQUARE ROOT ERROR', 'Cannot evaluate the square root of a negative number', 'Evaluate the square root of the positive number (' + textAprox.replace(/-/, '') + ') instead.')
      return
    }
    let i = 1
    while (true) {
      // If n is a perfect square
      if (i * i === num) {
        return i
      } else if (i * i > num) {
        let upperBound = i
        let lowerBound = i - 1
        // Adjust the starting range based on the input value
        if (num > 100) {
          lowerBound = 10
        } else if (num > 10) {
          lowerBound = 1
        }
        let res = square(num, lowerBound, upperBound, 0)
        return res
      }
      i++
    }
  }
  return findSqrt(x)
}