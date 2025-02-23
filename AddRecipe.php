<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
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

        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                var textarea = event.target;
                var currentText = textarea.value;
                var cursorPosition = textarea.selectionStart;
                var updatedText = currentText.slice(0, cursorPosition) + '\n• ' + currentText.slice(cursorPosition);
                textarea.value = updatedText;
                textarea.selectionStart = textarea.selectionEnd = cursorPosition + 2;
                textarea.dispatchEvent(new Event('input'));
            }
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
                <li class="login-container">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <span class="user-info">
                            Welcome, <?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>
                        </span>
                        <button class="buttons" onclick="return handleLogout()" id="logout-btn">Logout</button>
                    <?php else: ?>
                        <button class="buttons" onclick="window.location.href='redirect.php'">Login/Signup</button>
                    <?php endif; ?>
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
        <div class='displayChange'>
            <p class='Heading1'>Adding Recipes</p>
            <div class='RecipeList'>
                <form accept-charset='UTF-8' action='process_recipe.php' method='post' id='recipeForm' enctype='multipart/form-data'>
                    <label for='recipeName'>Recipe Name:</label>
                    <input type='text' id='recipeName' name='INrecipeName' required>

                    <label for='recipeIngredients'>Recipe Ingredients:<img src='Images/Ingredients.png' class='images'></label>
                    <textarea onkeydown='handleKeyPress(event)' id='recipeIngredients' name='INrecipeIngredients' required></textarea>

                    <label for='recipeInstructions'>Recipe Instructions:<img src='Images/Instructions.png' class='images'></label>
                    <textarea onkeydown='handleKeyPress(event)' id='recipeInstructions' name='INrecipeInstructions' required></textarea>

                    <label for='recipeImage'>Recipe Image:</label>
                    <input type='file' id='recipeImage' name='INrecipeImage' accept='image/*' required>

                    <label for='dropdown'>Pick a food category:</label>
                    <select id='dropdown' name='Type'>
                        <option value='meats'>Meat</option>
                        <option value='fish'>Fish</option>
                        <option value='veggies'>Veggie</option>
                        <option value='pastas'>Pasta</option>
                        <option value='sandwiches'>Sandwich</option>
                        <option value='soups'>Soups</option>
                        <option value='desserts'>Desserts</option>
                        <option value='others'>Other</option>
                    </select>

                    <button type="submit" name="submit" class="buttons">Submit Recipe</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>