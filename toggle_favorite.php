<?php
session_start();
require_once 'db_config.php';
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if (!isset($_POST['recipe_id'])) {
    echo json_encode(['success' => false, 'error' => 'No recipe ID provided']);
    exit();
}

$con = getConnection();

$recipe_id = (int)$_POST['recipe_id'];

// First get current state
$stmt = $con->prepare("SELECT isFavourite FROM recipes WHERE recipe_id = ? AND user_id = ?");
$stmt->bind_param("ii", $recipe_id, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Toggle the state
$newState = $row['isFavourite'] ? 0 : 1;

// Update the database
$stmt = $con->prepare("UPDATE recipes SET isFavourite = ? WHERE recipe_id = ? AND user_id = ?");
$stmt->bind_param("iii", $newState, $recipe_id, $_SESSION['user_id']);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'isFavourite' => $newState]);
} else {
    echo json_encode(['success' => false, 'error' => 'Update failed']);
}

$con->close();
?>