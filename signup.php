<!DOCTYPE HTML>
<html>
<head>
    <title>Sign Up</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="style.css">
</head>
<body class="is-preload">
    <div class="login-container">
        <h2 class="Heading1">Sign Up</h2>
        
        <?php
        if(isset($_GET['error'])) {
            switch($_GET['error']) {
                case 'password_mismatch':
                    echo '<div class="message error">Passwords do not match!</div>';
                    break;
                case 'user_exists':
                    echo '<div class="message error">Username or email already exists!</div>';
                    break;
                case 'database':
                    echo '<div class="message error">An error occurred. Please try again.</div>';
                    break;
            }
        }
        ?>
        
        <form method="POST" action="process_signup.php">
            <div class="form-group">
                <label for="firstname">First Name:</label>
                <input type="text" id="firstname" name="firstname" required>
            </div>
            
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" name="signup">Sign Up</button>
        </form>
        
        <div class="signup-link">
            <p>Already have an account? <a href="redirect.php">Login</a></p>
        </div>
        
        <button onclick="window.location.href='Recipe_HomePage.php'" class="back-button">Back home</button>
    </div>
</body>
</html> 