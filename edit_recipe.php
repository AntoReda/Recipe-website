<?php
// Database connection
$servername = "localhost"; // Replace with your server name if necessary
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "recipewebsite"; // Replace with your database name

// Create a connection
$con = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Get the recipe name from the URL
$recipe_name = isset($_GET['Name']) ? $_GET['Name'] : '';
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if both identifiers are provided
if (empty($recipe_name) || $recipe_id === 0) {
    echo "Insufficient recipe information provided";
    exit();
}

// Fetch the recipe details using both identifiers
$sqlquery = "SELECT * FROM recipes WHERE Name='$recipe_name' AND recipe_id=$recipe_id";
$result = mysqli_query($con, $sqlquery);

// Check if recipe exists
if (!$result || mysqli_num_rows($result) == 0) {
    echo "Recipe not found";
    exit();
}

$recipe = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $instructions = $_POST['instructions'];
    $ingredients = $_POST['ingredients'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Simple file upload
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        $image = $recipe['Image']; // Keep existing image if no new one is uploaded
    }

    // Update the query using prepared statements
    $stmt = $con->prepare("UPDATE recipes SET Name = ?, Instructions = ?, Ingredients = ?, Image = ? WHERE Name = ? AND recipe_id = ?");
    $stmt->bind_param("sssssi", $name, $instructions, $ingredients, $image, $recipe_name, $recipe_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect with both identifiers
        header("Location: Recipe_Instructions.php?submit2=$name&id=$recipe_id");
        exit();
    } else {
        echo "Error updating recipe: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
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
        <h1>Edit Recipe</h1>
        <?php if ($recipe): ?>
        <form method="post" enctype="multipart/form-data">
            <label for="name">Recipe Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($recipe['Name']); ?>" required>

            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($recipe['Ingredients']); ?></textarea>

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($recipe['Instructions']); ?></textarea>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <?php if ($recipe['Image']): ?>
                <div class="current-image">
                    <p>Current image:</p>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($recipe['Image']); ?>" alt="Current recipe image" style="max-width: 200px;">
                </div>
            <?php endif; ?>

            <button type="submit" class="buttons">Save Changes</button>
        </form>
        <?php endif; ?>
    </main>
</body>
</html>
