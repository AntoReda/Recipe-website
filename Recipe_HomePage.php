<!DOCTYPE html>

<html>

<head>
    <title>Recipe Website</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="engine.js"></script>
    <script defer src="dynamic_styles.js"></script>
    <script defer src="math.js"></script>
</head>
<script>

     // Show or hide the div based on the selected tab
     function show(tabName) 
     {
        //hides all recipe boxes
        var allOtherDivs = document.getElementsByName('recipeBox');
        for (var i = 0; i < allOtherDivs.length; i++) 
        {
            allOtherDivs[i].style.display = 'none';
        } 
        //unhides the correct recipeBoxes
        var starDivs = document.getElementsByClassName(tabName); 
        for (var i = 0; i < starDivs.length; i++) {
        starDivs[i].style.display = 'block';
        } 
    }

  function showAll() {
      
    var allOtherDivs = document.getElementsByName('recipeBox');
        for (var i = 0; i < allOtherDivs.length; i++) {
            allOtherDivs[i].style.display = 'block';
    } 
    
  }
</script>
<body id="background">
<!--Title-->
<div class="displayChange" id="title">
    <nav>
        <ul>
            <li>
                <a href="Recipe_HomePage.php" >
                <image id="logo" src="Images/Logo.jpg"></image> </a>
           </li>
            <li><span class="Heading1">Recipe Website</span>
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
            <div style="background-color: #918e8e; padding:5px;">
                <label class="text2"> Change the color of main components
                    <div id="color-box1"><input type="color" id="color-picker1" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button color
                    <div id="color-box2"><input type="color" id="color-picker2" style="display:none;"></input></div>
                </label>
                <label class="text2"> Change the button hover color
                    <div id="color-box3"><input type="color" id="color-picker3" style="display:none;"></div>
                    </input>        </label>
                    <button class="buttons">Save</button>
            
        </div>
    </div>

</div>

<main>
    <div class="tab-container">
        <div class="tab">
          <input type="radio" id="tab1" name="tabs">
          <label for="tab1" onclick="showAll()">ALL</label>
        </div>
        <div class="tab">
          <input type="radio" id="tab2" name="tabs">
          <label for="tab2" onclick="show('meats')">Meats</label>
        </div>
        <div class="tab">
            <input type="radio" id="tab3" name="tabs">
            <label for="tab3" onclick="show('fish')">Fish</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab4" name="tabs">
            <label for="tab4" onclick="show('veggies')">Veggies</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab5" name="tabs">
            <label for="tab5" onclick="show('pastas')">Pasta</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab6" name="tabs">
            <label for="tab6"onclick="show('sandwiches')">Sandwich</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab7" name="tabs">
            <label for="tab7" onclick="show('soups')">Soups</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab8" name="tabs">
            <label for="tab8" onclick="show('desserts')">Desserts</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab9" name="tabs">
            <label for="tab9" onclick="show('others')">Other</label>
          </div>
          <div class="tab">
            <input type="radio" id="tab10" name="tabs">
            <label for="tab9" onclick="show('fav')">Favourites</label>
          </div>
        <!-- Add more tabs here if needed -->
      </div>

    <!--Inside of the recipe list-->
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
            
            $table = mysqli_query($con,"SELECT * FROM recipes") or die(mysqli_error($this->db_link));
                       
                        
                        
                        
						
						
    echo "
    <div class='displayChange'>
      <p class='Heading1'>Recipes</p>
            <div class='RecipeList'>";
            while($row = mysqli_fetch_array($table))
            {
            
            $name = $row['Name'] ;
            $instr = $row['Instructions'] ;
            $image = $row['Image'] ;
            $type = $row['Type'] ;
            //This $image var is stored as a BLOB in SQL database
            echo "<div name = 'recipeBox' class = '$type' style = 'display:none;'><form action='Recipe_Instructions.php' method='get' id='recipeForm' enctype='multipart/form-data'><button type='submit' name='submit2' value = '$name' id='recipeLogoBox'><img id='recipeLogo' src='data:image/jpeg;base64," . base64_encode($image) . "' alt='No Image Uploaded'> $name </button></form></div>";
            }
                
            
       echo "  <a href='AddRecipe.php'><button id='recipeButtonAdd'><img id='recipeAdd'src='Images/add.png'></button></a>
       </div>
    </div>";
    ?>
   
    
</main>
</body>

</html>