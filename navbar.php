<script defer src="dynamic_styles.js"></script>
<div class="displayChange" id="top-bar">
    <nav>
        <ul>
            <li>
                <a href="Recipe_HomePage.php">
                    <image id="logo" src="Images/Logo.jpg"></image>
                </a>
            </li>
            <li><span class="Heading1">Recipe Website</span></li>
            <li>
                <button class="text" id="color-picker-btn" onclick="colorPicker()">Color Picker</button>
            </li>
            <li class="login-container">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span class="user-info">
                        Welcome, <?php echo htmlspecialchars($_SESSION['firstname'] . ' ' . $_SESSION['lastname']); ?>
                    </span>
                    <button class="buttons" onclick="logoutWithReset()" id="logout-btn">Logout</button>
                <?php else: ?>
                    <button class="buttons" onclick="window.location.href='redirect.php'">Login/Signup</button>
                <?php endif; ?>
            </li>
            <li><button id="reset-styles-btn" class="buttons" onclick="resetToDefaults()">Reset Style</button></li>
            <li class="dropdown">
                <button class="button">Backgrounds</button>
                <div class="dropdown-content" id="sidebar">
                    <a href="#" onclick="styleHome()" class="text">Home</a>
                    <a href="#" onclick="styleSalmon()" class="text">Salmon</a>
                    <a href="#" onclick="styleVeggies()" class="text">Veggies</a>
                    <a href="#" onclick="styleCloud()" class="text">Cloud9</a>
                    <a href="#" onclick="styleRed()" class="text">Autumn Leaves</a>
                    <a href="#" onclick="styleCave()" class="text">Seaside City</a>
                    <a href="#" onclick="styleDesert()" class="text">Sandy Plains</a>
                    <a href="#" onclick="styleCube()" class="text">Cube Loop</a>
                    <a href="#" onclick="styleDark()" class="text">Dark Mode</a>
                </div>
            </li>
        </ul>
    </nav>

    <div id="color-hide">
        <div style="background-color: #525252; padding:5px;">
            <label class="text2"> Change the color of main components
                <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></div>
            </label>
            <label class="text2"> Change the button color
                <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></div>
            </label>
            <label class="text2"> Change the button hover color
                <div id="color-box3"><input type="color" id="color-picker3" style="display:none;"></div>
            </label>
            <label class="text2"> Change the text color
                <div id="color-box4"><input type="color" id="color-picker4" style="display:none;"></div>
            </label>
            <div style="text-align: center; margin-top: 10px;">
                <button id="save-styles-btn" class="buttons" onclick="saveStylePreferences()">Save Style</button>
            </div>
        </div>
    </div>
</div>

<script>
function logoutWithReset() {
    // First reset the styles
    resetToDefaults();
    
    // Wait a brief moment to ensure styles are reset before redirecting
    setTimeout(function() {
        window.location.href = 'logout.php';
    }, 100);
}
</script> 