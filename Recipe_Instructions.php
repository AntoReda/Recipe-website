<?php
session_start();
require_once 'db_config.php';
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

<body id="background" class="displayChange">
<?php include 'loading_spinner.php'; ?>
<?php include 'navbar.php'; ?>
    <main>
        <div id="recipe-page" class="displayChange">
            <?php

                $con = getConnection();              
                
                if (isset($_POST['submit2'])) {
                    $recipeName = $_POST['submit2'];
                    $sqlquery = "SELECT * FROM recipes WHERE Name='$recipeName' ";
                    $table = mysqli_query($con,$sqlquery) or die(mysqli_error($this->db_link));
                    
                    // Check if we got any results
                    if ($row = mysqli_fetch_array($table)) {
                        $name = $row['name'];
                        $instr = $row['instructions'];
                        $ingr = $row['ingredients'];
                        $image = $row['image'];
                        $type = $row['type'];
                        $recipe_id = $row['recipe_id'];
                        $duration = $row['duration'];
                        $portions = $row['portions'];
                        
                        $instr2 = nl2br($instr);
                        $ingr2 = nl2br($ingr);
                        
                        // Check if instructions is valid JSON before decoding
                        $instructions_data = json_decode($row['instructions'], true);
                        
                        echo "<div class='recipe-page'>";
                        
                        // Recipe Header Section
                        echo "<div class='recipe-header'>
                                <h1 class='recipe-title'>$name</h1>
                                <div class='recipe-metadata'>
                                    <div class='metadata-field'>
                                        <span class='text'>Duration: $duration minutes</span>
                                    </div>
                                    <div class='metadata-field'>
                                        <span class='text'>Portions: $portions</span>
                                    </div>
                                </div>
                                <div class='recipe-actions'>
                                    <button class='favorite-button " . ($row['isFavourite'] ? 'active' : '') . "' 
                                            onclick='toggleFavorite($recipe_id)'>
                                        " . ($row['isFavourite'] ? '★' : '☆') . "
                                    </button>
                                    <button class='edit-button' 
                                            onclick='window.location.href=\"edit_recipe.php?name=$name&recipe_id=$recipe_id\"'>
                                        Edit Recipe
                                    </button>
                                </div>
                              </div>";
                        
                        // Recipe Main Content
                        echo "<div class='recipe-content'>
                                <!-- Left Column -->
                                <div class='recipe-main-info'>
                                    <div class='recipe-image-container'>
                                        <img class='recipe-main-image' 
                                             src='data:image/jpeg;base64," . base64_encode($row['image']) . "' 
                                             alt='Recipe Image'
                                             loading='lazy'
                                             onerror=\"this.src='Images/black-square.jpg';\">
                                    </div>
                                    
                                    <div class='ingredients-section'>
                                        <h2>Ingredients</h2>
                                        <div class='ingredients-list'>" . 
                                            nl2br(htmlspecialchars($row['ingredients'])) . 
                                        "</div>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class='instructions-section'>
                                    <h2>Instructions</h2>";
                        
                        if ($instructions_data && isset($instructions_data['steps'])) {
                            echo "<div class='steps-container'>";
                            foreach ($instructions_data['steps'] as $step) {
                                echo "<div class='step-card'>
                                        <div class='step-content'>
                                            <h3>Step {$step['number']}</h3>
                                            <p>" . nl2br(htmlspecialchars($step['instructions'])) . "</p>
                                        </div>";
                                
                                if (isset($step['image']) && $step['image']) {
                                    echo "<div class='step-image-container'>
                                            <img class='step-image' 
                                                 src='data:image/jpeg;base64,{$step['image']}' 
                                                 alt='Step {$step['number']} image'
                                                 loading='lazy'>
                                          </div>";
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                        }
                        
                        echo "</div></div></div>";
                    } else {
                        echo "<p>Recipe not found</p>";
                    }
                }
           
            ?>
        </div>
    </main>
    <script>
    function toggleFavorite(recipeId) {
        fetch('toggle_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'recipe_id=' + recipeId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const btn = document.querySelector('.favorite-button');
                if (data.isFavourite) {
                    btn.textContent = '★';
                    btn.classList.add('active');
                } else {
                    btn.textContent = '☆';
                    btn.classList.remove('active');
                }
            }
        });
    }
    </script>
</body>

</html>