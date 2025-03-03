<?php
require_once 'db_config.php';

$con = getConnection();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate passwords match
    if ($password !== $confirm_password) {
        header("Location: signup.php?error=password_mismatch");
        exit();
    }
    
    // Check if username already exists
    $check_sql = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = $conn->query($check_sql);
    
    if ($result->num_rows > 0) {
        header("Location: signup.php?error=user_exists");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $sql = "INSERT INTO users (username, email, password, firstname, lastname) 
            VALUES ('$username', '$email', '$hashed_password', '$firstname', '$lastname')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: redirect.php?success=registered");
        exit();
    } else {
        header("Location: signup.php?error=database");
        exit();
    }
}

$conn->close();
?> 