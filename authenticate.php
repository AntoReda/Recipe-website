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
    die("Connection failed: " . $conn->connect_error);
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