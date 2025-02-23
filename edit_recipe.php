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

    // Update the recipe in the database using both identifiers
    $update_query = "UPDATE recipes SET Name = '$name', Instructions = '$instructions', Ingredients = '$ingredients' WHERE Name = '$recipe_name' AND recipe_id = $recipe_id";
    mysqli_query($con, $update_query);

    // Redirect with both identifiers
    header("Location: Recipe_Instructions.php?submit2=$name&id=$recipe_id");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Recipe</h1>
    <?php if ($recipe): ?>
    <form method="post">
        <label for="name">Recipe Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($recipe['Name']); ?>" required>

        <label for="ingredients">Ingredients:</label>
        <textarea id="ingredients" name="ingredients" required><?php echo htmlspecialchars($recipe['Ingredients']); ?></textarea>

        <label for="instructions">Instructions:</label>
        <textarea id="instructions" name="instructions" required><?php echo htmlspecialchars($recipe['Instructions']); ?></textarea>

        <button type="submit" class="buttons">Save Changes</button>
    </form>
    <?php endif; ?>
</body>
</html>
