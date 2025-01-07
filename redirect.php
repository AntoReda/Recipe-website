<!DOCTYPE HTML>

<html>
<head>
    <title>Login/Signup</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css">
</head>
<body class="is-preload">
    <div class="login-container">
        <h2 class="Heading1">Login</h2>
        
        <?php
        // Display success message if registration was successful
        if(isset($_GET['success']) && $_GET['success'] == 'registered') {
            echo '<div class="message success">Registration successful! Please login.</div>';
        }
        // Display error message if login failed
        if(isset($_GET['error']) && $_GET['error'] == 'invalid') {
            echo '<div class="message error">Invalid username or password.</div>';
        }
        ?>
        
        <form method="POST" action="authenticate.php">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" name="login">Login</button>
        </form>
        
        <div class="signup-link">
            <p>Don't have an account?  <button onclick="window.location.href='signup.php'" class="back-button">Sign Up</button></p>
        </div>
        
        <button onclick="window.location.href='Recipe_HomePage.php'" class="back-button">Back home</button>
    </div>
</body>
</html>