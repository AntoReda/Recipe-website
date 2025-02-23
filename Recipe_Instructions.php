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
    <title>Recipe Instructions</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .buttons {
            background-color: var(--button-color, #918e8e);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            display: block;  /* Ensures button is visible as a block element */
            clear: both;     /* Clears any floats */
            position: relative; /* Ensures proper stacking */
            z-index: 1;      /* Ensures button is above other elements */
        }

        .buttons:hover {
            background-color: var(--button-hover-color, #798177);
        }

        /* Adjust outer container to accommodate button */
        .outerBox {
            margin-bottom: 60px; /* Makes space for the button */
        }
    </style>
    <script defer src="dynamic_styles.js"></script>
    <script defer src="math.js"></script>
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

<body id="background" class="displayChange">
    <!-- Loading overlay -->
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>

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

        <!--Inside of the calculator box-->
        <div class="displayChange">
            <div class="RecipeList">
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
              
               
               
               
                if (isset($_GET['submit2'])) {
                    $recipeName = $_GET['submit2'];
                    $sqlquery = "SELECT * FROM recipes WHERE Name='$recipeName' ";
                    $table = mysqli_query($con,$sqlquery) or die(mysqli_error($this->db_link));
                    //Adds the query to a variable $table
                    
                while($row = mysqli_fetch_array($table))
                {
                
                    $name = $row['Name'] ;
                    $instr = $row['Instructions'] ;
                    $ingr = $row['Ingredients'];
                    $image = $row['Image'] ;
                    $type = $row['Type'] ;
                    $recipe_id = $row['recipe_id'];
                }
                $instr2=nl2br($instr);
                $ingr2=nl2br($ingr);
                //below it displays the contents of the query in a stylized manner
                echo " 
                <div style='border-right-style:groove; padding:0.7vw; height:25vw;'>
                <button class='text' onclick='window.location.href=\"edit_recipe.php?Name=$name&id=$recipe_id\"'>Edit Recipe</button>
                <p class ='Heading1'>$name Recipe:</p>
                <img id='recipeInstructionsLogo' 
                     src='data:image/jpeg;base64," . base64_encode($image) . "' 
                     alt='Recipe Image'
                     loading='lazy'
                     onerror=\"this.src='Images/default-recipe.jpg';\">
                </div>
                <div class='outerBox'>
                <div class = 'IngredientsBox'>
                <p class ='Heading1'>Ingredients:</p>
                <p accept-charset='UTF-8' class ='Heading2'>$ingr2:</p>
                </div>
    
                <div class = 'InstructionsBox'>
                <p class ='Heading1'>Instructions:</p>
                <p accept-charset='UTF-8' class ='Heading2'>$instr2:</p>
                </div>
                
                </div>
                ";
            }
           
            ?>
                
            </div>
        </div>
    </main>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('loading-overlay').style.display = 'none';
            }, 1000);
        });
    </script>
</body>

</html>