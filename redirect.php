<!DOCTYPE HTML>

<html>



	<head>
	
		<title>Adding Recipe</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="style.css">
	</head>
	<body class="is-preload">
					
				
							

<?php
					ini_set('display_errors', 1);
                    ini_set('display_startup_errors', 1);
                    error_reporting(E_ALL);

                    $servername = "localhost"; // Replace with your server name if necessary
                    $username = "root"; // Replace with your MySQL username
                    $password = ""; // Replace with your MySQL password
                    $database = "recipewebsite"; // Replace with your database name
                    
                    // Create a connection
                    $con = new mysqli($servername, $username, $password, $database);

						// Check connection
						if (mysqli_connect_errno())
						{
							echo "Failed to connect to MySQL: " . mysqli_connect_error();
						}

						//Test Logic
						$result = mysqli_query($con,"SELECT * FROM recipes") or die(mysqli_error($this->db_link));

                      
                        if (isset($_POST['submit'])) {
                            $name = $_POST['INrecipeName'];
                            $instr = $_POST['INrecipeInstructions'];
                            $image = $_FILES['INrecipeImage']['tmp_name'];
							$type = $_POST['Type'];
							$ingr = $_POST['INrecipeIngredients'];
                            // Read the image file
                            $imgData = file_get_contents($image);
                        
                            // Escape special characters in the binary data
                            $imgData = mysqli_real_escape_string($con, $imgData);
                        
                            $sql = "INSERT INTO recipes VALUES ('$name', '$instr', '$imgData', '$type', '$ingr' )";
                            mysqli_query($con, $sql);
                        }
						
                        

                        
							
/*
						while($row = mysqli_fetch_array($result))
						{
							$Name[$index] = $row['Name'];
							$Instr[$index] = $row['Instructions'];
							$Image[$index] = $row['Image'];
							$index++;
						}


						

						//Removing entries
						for($i=0; $i<$index; $i++)
						{
							//the 'deletesubmit' is the name = ... to our different buttons which actually change dynamically using . $index . (the periods are used like concat in php)
							if (isset($_POST['deletesubmit0'. ($i+1)])) 
							{
								$name = $testName[$i];
								$age = $testAge[$i];
								$dob = $testDOB[$i];

							$sql = "DELETE FROM test WHERE name='$name' AND age='$age' AND DOB='$dob'";
							mysqli_query($con, $sql);
								
							}
					
                        }
						*/
					?>
					
					<p class='Heading1'>Recipe has been added!</p>
					<button onclick="window.location.href='Recipe_HomePage.php'" > Back home </button>
					
					
	</body>
</html>