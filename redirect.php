<!DOCTYPE HTML>

<html>
<head>
    <title>Login/Signup</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css">
    <script defer src="dynamic_styles.js"></script>
    <script>
        // Apply saved styles immediately to prevent flash
        const savedPrefs = localStorage.getItem('stylePreferences');
        if (savedPrefs) {
            const prefs = JSON.parse(savedPrefs);
            document.documentElement.style.setProperty('--main-color', prefs.mainColor);
            document.documentElement.style.setProperty('--button-color', prefs.buttonColor);
            document.documentElement.style.setProperty('--text-color', prefs.textColor);
            document.documentElement.style.setProperty('--background-url', prefs.backgroundUrl);
        }
    </script>
</head>
<body id="background">
    <!--Title-->
    <div class="displayChange" id="top-bar">
        <nav>
            <ul>
                <li>
                    <a href="Recipe_HomePage.php">
                        <image id="logo" src="Images/Logo.jpg"></image>
                    </a>
                </li>
                <li><span class="Heading1">Recipe Website</span></li>
                <li><span class="text" style="font-size: large;">by Antonio Reda</span></li>
                <li>
                    <button class="text" id="color-picker-btn" onclick="colorPicker()">Color Picker</button>
                </li>
                <li>
                    <button id="save-styles-btn" class="buttons" onclick="saveStylePreferences()">Save Style</button>
                    <button id="reset-styles-btn" class="buttons" onclick="resetToDefaults()">Reset Style</button>
                </li>
                <li class="dropdown">
                    <button class="button">Themes</button>
                    <div class="dropdown-content" id="sidebar">
                        <a href="#" onclick="styleHome()" class="text">Home</a>
                        <a href="#" onclick="styleSalmon()" class="text">Salmon</a>
                        <a href="#" onclick="styleVeggies()" class="text">Veggies</a>
                        <a href="#" onclick="styleCloud()" class="text">Cloud9</a>
                        <a href="#" onclick="styleRed()" class="text">Autumn Leaves</a>
                        <a href="#" onclick="styleCave()" class="text">Seaside City</a>
                        <a href="#" onclick="styleDesert()" class="text">Sandy Plains</a>
                        <a href="#" onclick="styleCube()" class="text">Cube Loop</a>
                        <a href="#" onclick="styleDark()" class="text">Dark Mode</a>
                    </div>
                </li>
            </ul>
        </nav>

        <div id="color-hide">
            <div style="background-color: #525252; padding:5px;">
                <label class="text2"> Change the color of main components
                    <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></div>
                </label>
                <label class="text2"> Change the button color
                    <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></div>
                </label>
                <label class="text2"> Change the button hover color
                    <div id="color-box3"><input type="color" id="color-picker3" style="display:none;"></div>
                </label>
                <label class="text2"> Change the text color
                    <div id="color-box4"><input type="color" id="color-picker4" style="display:none;"></div>
                </label>
            </div>
        </div>
    </div>

    <main>
    <button onclick="window.location.href='Recipe_HomePage.php'" class="buttons">Back home</button>
        <div class="displayChange">
            <div class="login-container">
                <h2 class="Heading1">Login</h2>
                
                <?php
                // Display success message if registration was successful
                if(isset($_GET['success']) && $_GET['success'] == 'registered') {
                    echo '<div class="message success">Registration successful! Please login.</div>';
                }
                // Display error message if login failed
                if(isset($_GET['error']) && $_GET['error'] == 'invalid') {
                    echo '<div class="message error">Invalid username or password.</div>';
                }
                ?>
                
                <form method="POST" action="authenticate.php">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="buttons">Login</button>
                </form>
                
                <div class="signup-link">
                    <p class="text">Don't have an account? <button onclick="window.location.href='signup.php'" class="buttons">Sign Up</button></p>
                </div>
                
                
            </div>
            
        </div>
        
    </main>
</body>
</html>