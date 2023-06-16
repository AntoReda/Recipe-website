<!DOCTYPE html>

<html>

<head>
    <title>Recipe Website</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="dynamic_styles.js"></script>
   
</head>

<body id="background">
<!--Title-->
<div class="displayChange" id="title">
    <nav>
        <ul>
            <li><a href="Recipe_HomePage.php">
                <image id="logo" src="Images/Logo.jpg"></image>
            </a></li>
            <li><span class="Heading1">Recipe Website</span>
            </li>
            <li><span class="text" style="font-size: medium; font-size: x-large;">&emsp; by Antonio Reda  &emsp;</span></li>
            <li>
                <button id="color-picker-btn" onclick="colorPicker()">Color Picker</button>
            </li>
            <li>
                <button id="login" onclick="login()">Login/Signup</button>
            </li>
            <li class="dropdown">
                <button class="button" style="width:17vw;">Themes</button>
                <div class="dropdown-content" id="sidebar">
                    <a href="#" onclick="styleHome()" class="text">Home</a>
                    <a href="#" onclick="styleSalmon()" class="text">Salmon</a>
                    <a href="#" onclick="stylePink()" class="text">Bubble Gum</a>
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
            <div style="background-color: #918e8e;; padding:5px;">
                <label class="text2"> Change the color of main components
                    <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button color
                    <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button hover color
                    <div id="color-box3"><input type="color" id="color-picker3" style="display:none;"></div>
                    </input>        </label>
                    <button class="buttons">Save</button>
            
        </div>
    </div>

</div>

<main>
<?php
						$servername = "localhost"; // Replace with your server name if necessary
                        $username = "root"; // Replace with your MySQL username
                        $password = ""; // Replace with your MySQL password
                        $database = "recipewebsite"; // Replace with your database name
                        
                        // Create a connection
                        $con = mysqli_connect($servername, $username, $password, $database);
						
						// Check connection
						if (mysqli_connect_errno())
						{
						echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}
			
    echo "
    <div class='displayChange'>
      <p class='Heading1'>Recipes</p>
            <div class='RecipeList'>
                <form action='redirect.php' method='post' id='recipeForm' enctype='multipart/form-data'>
                    <label for='recipeName'>Recipe Name:</label>
                    <input type='text' id='recipeName' name='INrecipeName'required>
                  
                    <label for='recipeInstructions'>Recipe Instructions:</label>
                    <textarea id='recipeInstructions' name='INrecipeInstructions' required></textarea>
                  
                    <label for='recipeImage'>Recipe Image:</label>
                    <input type='file' id='recipeImage' name='INrecipeImage' accept='image' required>
                    <form action='process_form.php' method='POST'>
                    <label for='dropdown'>Pick a food category:</label>
                    <select id='dropdown' name='Type'>
                      <option value='meat'>Meat</option>
                      <option value='fish'>Fish</option>
                      <option value='veggie'>Veggie</option>
                      <option value='pasta'>Pasta</option>
                      <option value='Sandwhich'>Sandwhich</option>
                      <option value='soups'>Soups</option>
                      <option value='desserts'>Desserts</option>
                      <option value='other'>Other</option>
                    </select>
                   
                    <input type='submit' value='Submit' name='submit'>
                  </form>
                
            
        </div>
    </div>";
    ?>
</main>
</body>

</html>