<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "recipewebsite";

$con = mysqli_connect($servername, $username, $password, $database);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['INrecipeName']);
    $ingredients = mysqli_real_escape_string($con, $_POST['INrecipeIngredients']);
    $instructions = mysqli_real_escape_string($con, $_POST['INrecipeInstructions']);
    $type = mysqli_real_escape_string($con, $_POST['Type']);
    $user_id = $_SESSION['user_id'];

    // Handle image upload
    if(isset($_FILES['INrecipeImage']) && $_FILES['INrecipeImage']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['INrecipeImage']['tmp_name']);
        
        // Prepare and execute the query
        $stmt = $con->prepare("INSERT INTO recipes (Name, Instructions, Ingredients, Image, Type, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        $null = NULL;
        $stmt->bind_param("sssbsi", $name, $instructions, $ingredients, $null, $type, $user_id);
        $stmt->send_long_data(3, $image);
        
        if ($stmt->execute()) {
            header("Location: Recipe_HomePage.php?success=added");
            exit();
        } else {
            header("Location: AddRecipe.php?error=failed");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: AddRecipe.php?error=image");
        exit();
    }
}

$con->close();
?> 