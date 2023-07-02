<!DOCTYPE html>

<html>

<head>
    <title>Recipe</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="dynamic_styles.js"></script>
    <script defer src="math.js"></script>
</head>

<body id="background">
<!--Title-->
<div class="displayChange" id="title">
    <nav>
        <ul>
            <li><a href="Recipe_HomePage.php">
                <image id="logo" src="Images/Logo.jpg"></image>
            </a></li>
            <li><span class="text" style="text-decoration: underline;  font-size: x-large;">Recipe Website</span>
            </li>
            <li><span class="text" style="font-size: medium; font-size: x-large;">&emsp; by Antonio Reda  &emsp;</span></li>
            <li>
                <button id="color-picker-btn" onclick="colorPicker()">Color Picker</button>
            </li>
            <li>
                <button id="login" onclick="login()">Login/Signup</button>
            </li>
            <li class="dropdown">
                <button class="button" style="width:17vw;">Themes</button>
                <div class="dropdown-content" id="sidebar">
                    <a href="#" onclick="styleHome()" class="text">Home</a>
                    <a href="#" onclick="styleSalmon()" class="text">Salmon</a>
                    <a href="#" onclick="stylePink()" class="text">Bubble Gum</a>
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
    <div id="color-picker">
        <div id="color-hide">
            <div id="" style="background-color: #525252;; padding:5px;">
                <label class="text2"> Change the color of main components
                    <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button color
                    <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button hover color
                    <div id="color-box3"><input type="color" id="color-picker3" style="display:none;"></div>
                    </input>        </label>
            </div>
        </div>
    </div>

</div>

<main>

    <!--Inside of the calculator box-->
    <div class="displayChange">
        <div class="RecipeList">
        <?php

            $servername = "localhost"; // Replace with your server name if necessary
            $username = "root"; // Replace with your MySQL username
            $password = ""; // Replace with your MySQL password
            $database = "recipewebsite"; // Replace with your database name
            
            // Create a connection
            $con = mysqli_connect($servername, $username, $password, $database);
						
            // Check connection
            if (mysqli_connect_errno())
            {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
          
           
           
           
            if (isset($_GET['submit2'])) {
                $recipeId = $_GET['submit2'];
                $sqlquery = "SELECT * FROM recipes WHERE Name='$recipeId' ";
                $table = mysqli_query($con,$sqlquery) or die(mysqli_error($this->db_link));
                //Adds the query to a variable $table
                
            while($row = mysqli_fetch_array($table))
            {
            
                $name = $row['Name'] ;
                $instr = $row['Instructions'] ;
                $ingr = $row['Ingredients'];
                $image = $row['Image'] ;
                $type = $row['Type'] ;              
              //retrieves the variables of the query in 
            }
            $instr2=nl2br($instr);
            $ingr2=nl2br($ingr);
             //below it displays the comntents of the query in a stylized manner
             echo " 
             <div style='border-right-style:groove; padding:0.7vw; height:25vw;'>
             <p class ='Heading1'>$name Recipe:</p>
             <img id='recipeInstructionsLogo' src='data:image/jpeg;base64," . base64_encode($image) . "' alt='No Image Uploaded'>
             </div>
             <div class='outerBox'>
             <div class = 'IngredientsBox'>
             <p class ='Heading1'>Ingredients:</p>
             <p accept-charset='UTF-8' class ='Heading2'>$ingr2:</p>
             </div>
 
             <div class = 'InstructionsBox'>
             <p class ='Heading1'>Instructions:</p>
             <p accept-charset='UTF-8' class ='Heading2'>$instr2:</p>
             </div>
 
             </div>
             
             ";
        }
       
        ?>
            
        </div>
    </div>
</main>
</body>

</html>