<?php
session_start();
require_once 'db_config.php';
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}

$con = getConnection();

// Check if recipe ID is provided
if (!isset($_POST['recipe_id'])) {
    echo "No recipe specified";
    exit();
}

$recipe_id = (int)$_POST['recipe_id'];

// Check if the user owns this recipe
$stmt = $con->prepare("SELECT user_id FROM recipes WHERE recipe_id = ?");
$stmt->bind_param("i", $recipe_id);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe || $recipe['user_id'] != $_SESSION['user_id']) {
    echo "You don't have permission to delete this recipe";
    exit();
}

// Delete the recipe
$stmt = $con->prepare("DELETE FROM recipes WHERE recipe_id = ?");
$stmt->bind_param("i", $recipe_id);

if ($stmt->execute()) {
    // Redirect to homepage after successful deletion
    header("Location: Recipe_HomePage.php");
    exit();
} else {
    echo "Error deleting recipe: " . $stmt->error;
}

$con->close();
?> 