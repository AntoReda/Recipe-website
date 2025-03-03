<!DOCTYPE HTML>

<html>
<head>
    <title>Login/Signup</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
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
<?php include 'loading_spinner.php'; ?>
<?php include 'navbar.php'; ?>
    <main>
    <button onclick="window.location.href='Recipe_HomePage.php'" class="buttons">Back home</button>
        <div class="displayChange">
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
                        <label type="text" for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label type="text" for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" name="login" class="buttons">Login</button>
                </form>
                
                <div class="signup-link">
                    <p class="text">Don't have an account? <button onclick="window.location.href='signup.php'" class="buttons">Sign Up</button></p>
                </div>
                
                
            </div>
            
        </div>
        
    </main>
</body>
</html>