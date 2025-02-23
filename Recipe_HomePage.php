<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>
   
    <title>Recipe Website</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="engine.js"></script>
    <script defer src="dynamic_styles.js"></script>
    <script defer src="math.js"></script>
    <style>
        body {
            display: none;
        }
    </style>
</head>
<script>

     // Show or hide the div based on the selected tab
     function show(tabName) 
     {
        //hides all recipe boxes
        var allOtherDivs = document.getElementsByName('recipeBox');
        for (var i = 0; i < allOtherDivs.length; i++) 
        {
            allOtherDivs[i].style.display = 'none';
        } 
        //unhides the correct recipeBoxes
        var starDivs = document.getElementsByClassName(tabName); 
        for (var i = 0; i < starDivs.length; i++) {
        starDivs[i].style.display = 'block';
        } 
    }

  function showAll() {
      
    var allOtherDivs = document.getElementsByName('recipeBox');
        for (var i = 0; i < allOtherDivs.length; i++) {
            allOtherDivs[i].style.display = 'block';
    } 
    
  }
</script>
<body id="background">
    <div id="loading-overlay">
        <div class="spinner"></div>
    </div>
<!--Title-->
<div class="displayChange" id="top-bar">
    <nav>
        <ul>
            <li>
                <a href="Recipe_HomePage.php" >
                <image id="logo" src="Images/Logo.jpg"></image> </a>
           </li>
            <li><span class="Heading1">Recipe Website</span>
            </li>
            <li><span class="text" style="font-size: large;">by Antonio Reda</span></li>
            <li>
                <button  class="text" id="color-picker-btn" onclick="colorPicker()">Color Picker</button>
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
            <div style="background-color: #918e8e; padding:5px;">
                <label class="text2"> Change the color of main components
                    <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button color
                    <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></input></div>
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


    
    <?php
if(isset($_GET['success']) && $_GET['success'] == 'added') {
    echo '<div class="message success">Recipe added successfully!</div>';
}
?>
    <!--Inside of the recipe list-->
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

            // In your database query section:
            if (isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $table = mysqli_query($con,"SELECT * FROM recipes WHERE user_id = '$user_id'") or die(mysqli_error($con));
            } else {
                // If not logged in, show message or redirect
                echo "<div class='login-message'>Please <a href='redirect.php'>login</a> to view your recipes.</div>";
                exit();
            }
                       
    ?>
    <?php if(isset($_SESSION['user_id'])): ?>
        <div class="tab-container">
            <div class="tab">
                <input type="radio" id="tab1" name="tabs">
                <label for="tab1" onclick="showAll()">ALL</label>
            </div>
            <div class="tab">
              <input type="radio" id="tab2" name="tabs">
              <label for="tab2" onclick="show('meats')">Meats</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab3" name="tabs">
                <label for="tab3" onclick="show('fish')">Fish</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab4" name="tabs">
                <label for="tab4" onclick="show('veggies')">Veggies</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab5" name="tabs">
                <label for="tab5" onclick="show('pastas')">Pasta</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab6" name="tabs">
                <label for="tab6"onclick="show('sandwiches')">Sandwich</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab7" name="tabs">
                <label for="tab7" onclick="show('soups')">Soups</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab8" name="tabs">
                <label for="tab8" onclick="show('desserts')">Desserts</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab9" name="tabs">
                <label for="tab9" onclick="show('others')">Other</label>
            </div>
            <div class="tab">
                <input type="radio" id="tab10" name="tabs">
                <label for="tab9" onclick="show('fav')">Favourites</label>
            </div>
        </div>
    <?php endif; ?>
    <div class='displayChange' id="recipes-box">
        <p class='Heading1'>Recipes</p>
        <div class='RecipeList'>
<?php
    while($row = mysqli_fetch_array($table)) {
        $name = htmlspecialchars($row['Name']);
        $type = htmlspecialchars($row['Type']);
        $recipe_id = $row['recipe_id'];
        
        echo "<div name='recipeBox' class='$type' style='display:none;'>";
        echo "<form action='Recipe_Instructions.php' method='get' id='recipeForm'>";
        echo "<input type='hidden' name='id' value='$recipe_id'>";
        echo "<button type='submit' name='submit2' value='$name' id='recipeLogoBox'>";
        echo "<img id='recipeLogo' 
                 src='data:image/jpeg;base64," . base64_encode($row['Image']) . "' 
                 alt='$name'
                 loading='lazy'
                 onerror=\"this.src='Images/default-recipe.jpg';\">";
        echo htmlspecialchars($name);
        echo "</button></form></div>";
    }
?>
            <a href='AddRecipe.php'><button id='recipeButtonAdd'><img id='recipeAdd' src='Images/add.png'></button></a>
        </div>
    </div>
<?php
    ?>
   
    
</main>
</body>

</html>