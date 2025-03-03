<?php
session_start();
require_once 'db_config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}

$con = getConnection();

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add validation
    if (!isset($_POST['INrecipeName']) || empty($_POST['INrecipeName'])) {
        die("Recipe name is required");
    }
    if (!isset($_POST['INrecipeIngredients']) || empty($_POST['INrecipeIngredients'])) {
        die("Ingredients are required");
    }
   

    $name = $_POST['INrecipeName'];
    $ingredients = $_POST['INrecipeIngredients'];
    $type = $_POST['type'];
    $duration = floatval($_POST['duration']);
    $portions = floatval($_POST['portions']);
    
    // Handle main recipe image with proper encoding
    if (isset($_FILES['INrecipeImage']) && $_FILES['INrecipeImage']['error'] == 0) {
        $main_image = file_get_contents($_FILES['INrecipeImage']['tmp_name']);
    } else {
        // Use default image
        $main_image = file_get_contents('Images/not-found.jpg');
    }
    
    // Create instructions JSON structure
    $instructions_data = [
        'steps' => []
    ];
    
    // Process each step
    foreach ($_POST['step_instructions'] as $index => $instructions) {
        $step_data = [
            'number' => $index + 1,  // Start step numbers at 1
            'instructions' => $instructions,
            'image' => null
        ];
        
        // Check if an image was uploaded for this step
        if (isset($_FILES['step_image']) && 
            isset($_FILES['step_image']['name'][$index]) && 
            $_FILES['step_image']['error'][$index] == 0) {
            
            $step_image = file_get_contents($_FILES['step_image']['tmp_name'][$index]);
            $step_data['image'] = base64_encode($step_image);
        }
        
        $instructions_data['steps'][] = $step_data;
    }
    
    // Convert instructions data to JSON
    $instructions_json = json_encode($instructions_data);
    
    // Insert into database
    $stmt = $con->prepare("UPDATE recipes SET Name = ?, Instructions = ?, Ingredients = ?, Image = ?, duration = ?, portions = ? WHERE recipe_id = ?");
    $stmt->bind_param("ssssddi", $name, $instructions_json, $ingredients, $main_image, $duration, $portions, $_POST['id']);
    
    if ($stmt->execute()) {
        $new_recipe_id = $stmt->insert_id; // Get the ID of the newly inserted recipe
        
        // Start output buffering to ensure headers can be sent
        ob_start();
        ?>
        <form id="redirectForm" action="Recipe_Instructions.php" method="post">
            <input type="hidden" name="id" value="<?php echo $new_recipe_id; ?>">
            <input type="hidden" name="submit2" value="<?php echo htmlspecialchars($name); ?>">
        </form>
        <script>
            document.getElementById('redirectForm').submit();
        </script>
        <?php
        ob_end_flush();
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

$con->close();
?> 