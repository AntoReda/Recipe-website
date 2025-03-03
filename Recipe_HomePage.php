<?php
session_start();
?>
<!DOCTYPE html>

<html>

<head>
   
    <title>Recipe Website</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="dynamic_styles.js"></script>
</head>
<script>
    // Add both DOMContentLoaded and window.onload handlers
    document.addEventListener('DOMContentLoaded', function() {
        showAll();
    });
    
    window.onload = function() {
        showAll();
        // Also check and select the "ALL" radio button
        document.getElementById('tab1').checked = true;
        
        // Check if we just reset styles (using a URL parameter)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('reset') === 'true') {
            // Clear any stored color preferences
            localStorage.removeItem('colorPreferences');
            // Remove the reset parameter from URL to prevent repeated resets
            window.history.replaceState({}, '', window.location.pathname);
        }
    }

    // Show or hide the div based on the selected tab
    function show(tabName) {
        //hides all recipe boxes
        var allOtherDivs = document.getElementsByName('recipeBox');
        for (var i = 0; i < allOtherDivs.length; i++) {
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
<?php include 'loading_spinner.php'; ?>

<?php include 'navbar.php'; ?>
<main>
<?php
    if(isset($_POST['success']) && $_POST['success'] == 'added') {
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
                <label for="tab10" onclick="show('fav')">Favourites</label>
            </div>
        </div>
    <?php endif; ?>
    <div class='displayChange' id="recipes-box">
        <p class='Heading1'>Recipes</p>
        <div class='RecipeList'>
<?php
    while($row = mysqli_fetch_array($table)) {
        $name = htmlspecialchars($row['name']);
        $type = htmlspecialchars($row['type']);
        $recipe_id = $row['instructions'];
        $isFavourite = $row['isFavourite'] ? 'fav' : ''; // Get favorite status
        
        // Add 'fav' to the class list if it's a favorite
        $classes = $type;
        if ($row['isFavourite']) {
            $classes .= ' fav';
        }
        
        echo "<div name='recipeBox' class='$classes' style='display:none;'>";
        echo "<form action='Recipe_Instructions.php' method='post' id='recipeForm'>";
        echo "<input type='hidden' name='id' value='$recipe_id'>";
        echo "<button type='submit' name='submit2' value='$name' id='recipeLogoBox'>";
        if ($row['isFavourite']) {
            echo "<span class='favorite-indicator'>★</span>";
        }
        echo "<img id='recipeLogo' 
                 src='data:image/jpeg;base64," . base64_encode($row['image']) . "' 
                 alt='$name'
                 loading='lazy'
                 onerror=\"this.src='Images/not-found.jpg';\">";
        echo htmlspecialchars($name);
        echo "</button></form></div>";
    }
?>
            <a href='AddRecipe.php'><button id='recipeButtonAdd'><img id='recipeAdd' src='Images/add.webp'></button></a>
        </div>
    </div>
<?php
    ?>
   
    
</main>
<style>
.favorite-indicator {
    position: absolute;
    top: 10px;
    right: 10px;
    color: gold;
    font-size: 24px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

#recipeLogoBox {
    position: relative;
}
</style>
</body>

</html>