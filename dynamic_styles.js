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
  var selectedColor4
  const colorPicker1 = document.querySelector('#color-picker1')
  const colorPicker2 = document.querySelector('#color-picker2')
  const colorPicker3 = document.querySelector('#color-picker3')
  const colorPicker4 = document.querySelector('#color-picker4')
  const colorPickerBox1 = document.querySelector('#color-box1')
  const colorPickerBox2 = document.querySelector('#color-box2')
  const colorPickerBox3 = document.querySelector('#color-box3')
  const colorPickerBox4 = document.querySelector('#color-box4')

  colorPicker1.addEventListener('input', () => {
    colorPickerBox1.style.backgroundColor = colorPicker1.value
    selectedColor1 = colorPicker1.value
    style(selectedColor1, selectedColor2, selectedColor3, 'url(\'Images/Logo.jpg\')', 'White', selectedColor4)
  })
  colorPicker2.addEventListener('input', () => {
    colorPickerBox2.style.backgroundColor = colorPicker2.value
    selectedColor2 = colorPicker2.value
    style(selectedColor1, selectedColor2, selectedColor3, 'url(\'Images/Logo.jpg\')', 'White', selectedColor4)
  })
  colorPicker3.addEventListener('input', () => {
    colorPickerBox3.style.backgroundColor = colorPicker3.value
    selectedColor3 = colorPicker3.value
    style(selectedColor1, selectedColor2, selectedColor3, 'url(\'Images/Logo.jpg\')', 'White', selectedColor4)
  })
  colorPicker4.addEventListener('input', () => {
    colorPickerBox4.style.backgroundColor = colorPicker4.value
    selectedColor4 = colorPicker4.value
    // Update all text elements with the new color
    const textElements = document.querySelectorAll('.text, .text2, .login-container, .change-text, .buttons, .user-info, nav ul li a, .dropdown-content a')
    textElements.forEach(element => {
      element.style.color = selectedColor4
    })
    style(selectedColor1, selectedColor2, selectedColor3, 'url(\'Images/Logo.jpg\')', 'White', selectedColor4)
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

  // Update text color for all relevant elements
  const textElements = document.querySelectorAll('.text, .text2, nav ul li a, .dropdown-content a, .login-container, .change-text, .buttons, .button, .user-info');
  textElements.forEach(element => {
    element.style.color = Text;
  });

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
  style('#E0D4C6', '#918e8e', '#798177', 'url(\'Images/Logo.jpg\')', 'White', 'White', 'rgb(204, 119, 8)', '#bbd0fc', 'white')
}

function styleSalmon () {
  style('#F2Be9C', '#F5E7B2', '#A07340', 'url(\'Images/salmon.png\')', 'White', 'Black', 'rgb(108, 86, 26)', 'rgb(108, 86, 26)', 'grey')
}

function styleVeggies () {
  style('#E0D4C6', '#AFC0AD', '#798177', 'url(\'Images/Veggies.jpg\')', 'White', 'White', 'rgb(204, 119, 8)', '#bbd0fc', 'white')
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
  style('#454545', '#4f544e', '#777f75', 'url(\'Images/black-square.jpg\')', 'White', 'White', 'rgb(153, 167, 150)', '#777f75', 'white')
}

function resetToDefaults() {
    // Clear saved preferences
    localStorage.removeItem('stylePreferences');
    
    // Apply default home theme
    styleHome();
    
    // Reset color pickers to default values
    document.getElementById('color-picker1').value = '#E0D4C6';
    document.getElementById('color-picker2').value = '#918e8e';
    document.getElementById('color-picker3').value = '#798177';
    document.getElementById('color-picker4').value = '#000000';
    
    alert('Styles reset to defaults!');
}

function saveStylePreferences() {
    // Get current color values and styles
    const elements = document.querySelectorAll('[class=displayChange]');
    const mainColor = elements[0]?.style.backgroundColor || '#E0D4C6';
    const buttons = document.querySelectorAll('button:not(.link-btn)');
    const buttonColor = buttons[0]?.style.backgroundColor || '#918e8e';
    const buttonHoverColor = document.getElementById('color-picker3')?.value || '#798177';
    const textColor = document.getElementById('color-picker4')?.value || '#000000';
    
    const stylePrefs = {
        mainColor: mainColor,
        buttonColor: buttonColor,
        buttonHoverColor: buttonHoverColor,
        textColor: textColor,
        backgroundUrl: document.getElementById('background').style.backgroundImage || 'url(\'Images/Logo.jpg\')',
        buttonText: buttons[0]?.style.color || 'White',
        equalsColor: document.querySelector('.equal')?.style.backgroundColor || 'rgb(204, 119, 8)',
        linkColor: document.querySelector('.link-btn')?.style.color || '#bbd0fc',
        linkHover: 'white'
    };

    localStorage.setItem('stylePreferences', JSON.stringify(stylePrefs));
    alert('Style preferences saved!');
}

window.onload = function() {
    // Load saved preferences
    const savedPrefs = localStorage.getItem('stylePreferences');
    
    if (savedPrefs) {
        const prefs = JSON.parse(savedPrefs);
        
        // Update color pickers
        document.getElementById('color-picker1').value = prefs.mainColor;
        document.getElementById('color-picker2').value = prefs.buttonColor;
        document.getElementById('color-picker3').value = prefs.buttonHoverColor;
        document.getElementById('color-picker4').value = prefs.textColor;
        
        // Update color picker boxes
        document.getElementById('color-box1').style.backgroundColor = prefs.mainColor;
        document.getElementById('color-box2').style.backgroundColor = prefs.buttonColor;
        document.getElementById('color-box3').style.backgroundColor = prefs.buttonHoverColor;
        document.getElementById('color-box4').style.backgroundColor = prefs.textColor;
        
        // Apply all saved styles including text color
        style(
            prefs.mainColor,
            prefs.buttonColor,
            prefs.buttonHoverColor,
            prefs.backgroundUrl,
            prefs.buttonText,
            prefs.textColor,  // This will now be applied to all text elements
            prefs.equalsColor,
            prefs.linkColor,
            prefs.linkHover
        );
    } else {
        // If no preferences, load default home theme
        styleHome();
    }
}

