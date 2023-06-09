function colorPicker () {

  const colorPicker = document.querySelectorAll('[id=color-picker1]')
  const colorPicker2 = document.querySelectorAll('[id=color-picker2]')
  const colorPicker3 = document.querySelectorAll('[id=color-picker3]')
  const colorHide = document.querySelectorAll('[id=color-hide]')

  for (var i = 0; i < colorPicker.length; i++) {
    if (colorPicker[i].style.display === 'none') {
      colorPicker[i].style.display = 'block'
      colorPicker2[i].style.display = 'block'
      colorPicker3[i].style.display = 'block'
      colorHide[i].style.display = 'block'
    } else {
      colorPicker[i].style.display = 'none'
      colorPicker2[i].style.display = 'none'
      colorPicker3[i].style.display = 'none'
      colorHide[i].style.display = 'none'
    }
  }
}

//A function that dynamically changes the color palette of the page with a color picker.
function handleColorPicker () {
  var selectedColor1
  var selectedColor2
  var selectedColor3
  const colorPicker1 = document.querySelector('#color-picker1')
  const colorPicker2 = document.querySelector('#color-picker2')
  const colorPicker3 = document.querySelector('#color-picker3')
  const colorPickerBox1 = document.querySelector('#color-box1')
  const colorPickerBox2 = document.querySelector('#color-box2')
  const colorPickerBox3 = document.querySelector('#color-box3')

  colorPicker1.addEventListener('input', () => {
    colorPickerBox1.style.backgroundColor = colorPicker1.value
    selectedColor1 = colorPicker1.value
    style(selectedColor1)
  })
  colorPicker2.addEventListener('input', () => {
    colorPickerBox2.style.backgroundColor = colorPicker2.value
    selectedColor2 = colorPicker2.value
    style(selectedColor1, selectedColor2)
  })
  colorPicker3.addEventListener('input', () => {
    colorPickerBox3.style.backgroundColor = colorPicker3.value
    selectedColor3 = colorPicker3.value
    style(selectedColor1, selectedColor2, selectedColor3)
  })
}

//make the function active 
handleColorPicker()

//Dynamic Styling logic for the buttons
function style (Calc, Buttons, Hover, URL, ButtonText, Text, Equals, linkColor, linkHover) {
  var elements = document.querySelectorAll('[class=displayChange]')
  for (var i = 0; i < elements.length; i++) {
    //Changes the color of the main components (calculator, navBarm  etc).
    elements[i].style.backgroundColor = Calc
  }
  var sidebar = document.querySelectorAll('[id=sidebar]')
  for (var i = 0; i < sidebar.length; i++) {
    //Changes the color of the themes box components.
    sidebar[i].style.backgroundColor = Calc
  }

  var buttons = document.querySelectorAll('button')
  for (var i = 0; i < buttons.length; i++) {
    if (buttons[i].className !== 'link-btn') {
      //Changes the color of the text inside the buttons.
      buttons[i].style.color = ButtonText
      //Changes the color of the buttons.
      buttons[i].style.backgroundColor = Buttons
      buttons[i].addEventListener('mouseover', function () {

        //Changes the color of the button during hover.
        this.style.backgroundColor = Hover
      })

      //Changes the color of the button after Hover.
      buttons[i].addEventListener('mouseout', function () {
        this.style.backgroundColor = Buttons
      })
    } else {
      buttons[i].style.color = linkColor

      buttons[i].onmouseover = function () {
        this.style.color = linkHover
      }

      buttons[i].onmouseout = function () {
        this.style.color = linkColor
      }
    }

  }
  //Changes the URL of the background.
  var picture = document.getElementById('background')
  picture.style.backgroundImage = URL

  //Changes the Color of the Text
  var writing = document.querySelectorAll('[class=text]')
  for (var i = 0; i < writing.length; i++) {
    writing[i].style.color = Text
  }
  var equal = document.querySelectorAll('[class=equal]')
  for (var i = 0; i < equal.length; i++) {
    //Changes the color of the equal sign.
    equal[i].style.backgroundColor = Equals
    equal[i].addEventListener('mouseout', function () {
      this.style.backgroundColor = Equals
    })
    equal[i].addEventListener('mouseover', function () {

      //Changes the color of the button during hover.
      this.style.backgroundColor = Equals
    })
  }
}

function styleHome () {
  //   style( CalcColor, ButtonColor, HoverColor, URL, ButtonTextColor, TextColor, Equal-button Color, link-color, linkhover-color )
  style('#3850d6', '#6890e6', 'grey', 'url(\'Images/Wave1.gif\')', 'White', 'White', 'rgb(204, 119, 8)', '#bbd0fc', 'white')
}

function styleGreen () {
  style('#9bcc3f', 'grey', 'black', 'url(\'Images/Green.gif\')', 'White', 'Black', 'rgb(108, 86, 26)', 'rgb(108, 86, 26)', 'grey')
}

function stylePink () {
  style('pink', '#8ed2ec', '#57b6db', 'url(\'Images/BubbleGum.gif\')', '#851b5f', null, 'rgb(225, 108, 154)', 'white', 'rgb(225, 108, 154)')
}

function styleCloud () {
  style('#FFF4D2', '#E3DFFD', '#E5D1FA', 'url(\'Images/Cloud.gif\')', 'Black', 'Black', 'rgb(124, 203, 255)', 'dimgray', 'rgb(124, 203, 255)')
}

function styleRed () {
  style('#862137', '#ed8c5d', '#393053', 'url(\'Images/red-forest.gif\')', 'White', 'Black', 'rgb(66, 63, 62)', 'black', '#393053')
}

function styleCave () {
  style('#3F5077', '#7aabb3', '#9DF1DF', 'url(\'Images/cave.gif\')', 'White', 'White', 'rgb(99, 119, 122)', '#89a6ab', 'rgb(99, 119, 122)')
}

function styleDesert () {
  style('#de7330', '#873924', '#F2DEBA', 'url(\'Images/Desert.gif\')', 'White', 'Black', 'rgb(191, 59, 59)', '#873924', 'rgb(191, 59, 59)')
}

function styleCube () {
  style('#f49db0', '#4f544e', '#777f75', 'url(\'Images/Cube.gif\')', 'White', 'Black', 'rgb(227, 75, 84)', '#4f544e', 'rgb(227, 75, 84)')
}

function styleDark () {
  style('#000000', '#4f544e', '#777f75', 'url(\'Images/black-square.jpg\')', 'White', 'White', 'rgb(153, 167, 150)', '#777f75', 'white')
}

