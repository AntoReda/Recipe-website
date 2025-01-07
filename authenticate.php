<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "recipewebsite";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    header("Location: database_error.php?error=connection");
    exit();
}

// Check if database exists
$db_check = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$database'");
if ($db_check->num_rows == 0) {
    header("Location: database_error.php?error=missing_database");
    exit();
}

// Check if users table exists
$table_check = $conn->query("SHOW TABLES LIKE 'users'");
if ($table_check->num_rows == 0) {
    header("Location: database_error.php?error=missing_table");
    exit();
}

if (isset($_POST['login'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    // Query to check if user exists
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            header("Location: Recipe_HomePage.php");
            exit();
        } else {
            header("Location: redirect.php?error=invalid");
            exit();
        }
    } else {
        header("Location: redirect.php?error=invalid");
        exit();
    }
}

$conn->close();
?> 