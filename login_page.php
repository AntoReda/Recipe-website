<!DOCTYPE html>
<html>
<head>
    <title>Login - Recipe Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body id="background">
    <div class="displayChange" id="title">
        <nav>
            <ul>
                <li>
                    <a href="Recipe_HomePage.php">
                        <image id="logo" src="Images/Logo.jpg"></image>
                    </a>
                </li>
                <li><span class="Heading1">Login/Signup</span></li>
            </ul>
        </nav>
    </div>

    <main>
        <div class="login-container">
            <div class="login-box">
                <h2>Login</h2>
                <form action="process_login.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>

            <div class="signup-box">
                <h2>Create Account</h2>
                <form action="process_signup.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    <button type="submit">Sign Up</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>