<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}

// Database connection with reconnect functionality
function getConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "recipewebsite";

    $con = mysqli_connect($servername, $username, $password, $database);
    
    if (mysqli_connect_errno()) {
        die("Failed to connect to MySQL: " . mysqli_connect_error());
    }

    // Set timeout only (max_allowed_packet needs to be set in MySQL configuration)
    mysqli_query($con, "SET wait_timeout=28800"); // 8 hours

    return $con;
}

// Get initial connection
$con = getConnection();

// Function to check and restore connection if needed
function checkConnection($con) {
    if (!mysqli_ping($con)) {
        mysqli_close($con);
        return getConnection();
    }
    return $con;
}

// Before executing any query, check connection
$con = checkConnection($con);

// Debug: Print the GET parameters
error_log("GET parameters: " . print_r($_GET, true));

// Get the recipe name and ID from the URL - check both upper and lowercase
$recipe_name = isset($_GET['name']) ? $_GET['name'] : (isset($_GET['name']) ? $_GET['name'] : '');
$recipe_id = isset($_GET['recipe_id']) ? (int)$_GET['recipe_id'] : 0;

// Debug: Print the values
error_log("Recipe name: " . $recipe_name);
error_log("Recipe ID: " . $recipe_id);

// Initialize variables
$name = '';
$ingredients = '';
$instructions = '';
$current_image = '';
$instructions_data = null;
$duration = null;
$portions = null;

// Check if we have at least one identifier
if (!empty($recipe_name) || $recipe_id !== 0) {
    // Modify query to be more flexible
    $query = "SELECT * FROM recipes WHERE ";
    $params = [];
    $types = "";
    
    if (!empty($recipe_name)) {
        $query .= "name = ?";
        $params[] = $recipe_name;
        $types .= "s";
    }
    
    if ($recipe_id !== 0) {
        if (!empty($recipe_name)) {
            $query .= " AND ";
        }
        $query .= "recipe_id = ?";
        $params[] = $recipe_id;
        $types .= "i";
    }
    
    $stmt = $con->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $ingredients = $row['ingredients'];
        $instructions = $row['instructions'];
        $current_image = 'data:image/jpeg;base64,' . base64_encode($row['image']);
        $instructions_data = json_decode($instructions, true);
        $duration = $row['duration'];
        $portions = $row['portions'];
    } else {
        echo "Recipe not found in database";
        exit();
    }
} else {
    echo "Please provide either a recipe name or ID";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ensure connection is alive before large operation
    $con = checkConnection($con);
    
    $recipe_id = $_POST['recipe_id'];
    $name = $_POST['recipe_name'];
    $ingredients = $_POST['ingredients'];
    $duration = floatval($_POST['duration']);
    $portions = floatval($_POST['portions']);
    
    // Build instructions JSON
    $instructions_array = ['steps' => []];
    foreach ($_POST['step_instructions'] as $index => $instruction) {
        $step = [
            'number' => $index + 1,
            'instructions' => $instruction
        ];
        
        // Handle step image if uploaded
        if (isset($_FILES['step_image']['tmp_name'][$index]) && !empty($_FILES['step_image']['tmp_name'][$index])) {
            $step_image = file_get_contents($_FILES['step_image']['tmp_name'][$index]);
            $step['image'] = base64_encode($step_image);
        } elseif ($instructions_data && isset($instructions_data['steps'][$index]['image'])) {
            // Keep existing image if no new one uploaded
            $step['image'] = $instructions_data['steps'][$index]['image'];
        }
        
        $instructions_array['steps'][] = $step;
    }
    $instructions_json = json_encode($instructions_array);
    
    // Handle main image
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == 0) {
        $main_image = file_get_contents($_FILES['main_image']['tmp_name']);
    } else {
        // Keep existing image
        $stmt = $con->prepare("SELECT Image FROM recipes WHERE recipe_id = ?");
        $stmt->bind_param("i", $recipe_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $main_image = $row['Image'];
    }
    
    // Update recipe
    $stmt = $con->prepare("UPDATE recipes SET Name = ?, Instructions = ?, Ingredients = ?, Image = ?, duration = ?, portions = ? WHERE recipe_id = ?");
    $stmt->bind_param("ssssddi", $name, $instructions_json, $ingredients, $main_image, $duration, $portions, $recipe_id);
    
    if ($stmt->execute()) {
        // Use POST redirect instead of GET
        ob_start();
        ?>
        <form id="redirectForm" action="Recipe_Instructions.php" method="post">
            <input type="hidden" name="id" value="<?php echo $recipe_id; ?>">
            <input type="hidden" name="submit2" value="<?php echo htmlspecialchars($name); ?>">
        </form>
        <script>
            document.getElementById('redirectForm').submit();
        </script>
        <?php
        ob_end_flush();
        exit();
    } else {
        echo "Error updating recipe: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Recipe</title>
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

<body id="background" class="displayChange">
<?php include 'loading_spinner.php'; ?>
<?php include 'navbar.php'; ?>
    <main>
        <form method="POST" enctype="multipart/form-data">
            <div id="recipe-page" class="displayChange">
                <div class="recipe-header">
                    <div class="recipe-title-edit">
                        <p class="Heading1">Recipe Name:</p>
                        <input type="text" 
                               name="recipe_name" 
                               value="<?php echo htmlspecialchars($name); ?>" 
                               class="text Heading2"
                               required
                               oninvalid="this.setCustomValidity('Please enter a recipe name')"
                               oninput="this.setCustomValidity('')">
                    </div>
                    <div class="recipe-metadata">
                        <div class="metadata-field">
                            <label class="text">Duration (minutes):</label>
                            <input type="number" 
                                   name="duration" 
                                   value="<?php echo htmlspecialchars($duration ?? ''); ?>" 
                                   step="0.1" 
                                   min="0" 
                                   class="text"
                                   required>
                        </div>
                        <div class="metadata-field">
                            <label class="text">Portions:</label>
                            <input type="number" 
                                   name="portions" 
                                   value="<?php echo htmlspecialchars($portions ?? ''); ?>" 
                                   step="0.1" 
                                   min="0" 
                                   class="text"
                                   required>
                        </div>
                    </div>
                    <div class="header-buttons">
                        <button type="submit" class="text">Save Recipe</button>
                        <button type="button" class="text" onclick="confirmDelete()">Delete Recipe</button>
                    </div>
                </div>

                <div class="recipe-content">
                    <!-- Left Column -->
                    <div class="recipe-main-info">
                        <div class="recipe-image-container">
                            <img class="recipe-main-image" 
                                 src="<?php echo $current_image; ?>" 
                                 alt="Recipe Image">
                            <div class="image-upload">
                                <h2>Change Main Image</h2>
                                <label class="file-upload-label">
                                    <input type="file" name="main_image" accept="image/*">
                                </label>
                            </div>
                        </div>
                        
                        <div class="ingredients-section">
                            <h2>Ingredients</h2>
                            <textarea name="ingredients" class="ingredients-input"><?php echo htmlspecialchars($ingredients); ?></textarea>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="instructions-section">
                        <h2>Instructions</h2>
                        <div class="steps-container" id="steps-container">
                            <?php
                            if ($instructions_data && isset($instructions_data['steps'])) {
                                foreach ($instructions_data['steps'] as $index => $step) {
                                    echo "<div class='step-card'>
                                            <div class='step-content'>
                                                <h3>Step " . ($index + 1) . "</h3>
                                                <textarea name='step_instructions[]' class='step-instructions'>" . htmlspecialchars($step['instructions']) . "</textarea>
                                                <div class='step-image-upload'>
                                                    <label class='file-upload-label'>
                                                        <input type='file' name='step_image[]' accept='image/*' onchange='showUploadSuccess(this)'>
                                                    </label>
                                                    <span class='upload-status text'></span>
                                                </div>
                                            </div>";
                                    
                                    if (isset($step['image']) && $step['image']) {
                                        echo "<div class='step-image-container'>
                                                <img class='step-image' src='data:image/jpeg;base64,{$step['image']}' alt='Step " . ($index + 1) . " image'>
                                              </div>";
                                    }
                                    echo "</div>";
                                }
                            }
                            ?>
                        </div>
                        <button type="button" id="add-step" class="add-step-button">Add Step</button>
                    </div>
                </div>

                <!-- Bottom buttons -->
                <div class="bottom-buttons">
                    <button type="submit" class="text">Save Recipe</button>
                    <button type="button" class="text" onclick="confirmDelete()">Delete Recipe</button>
                </div>
            </div>

            <!-- Hidden fields for recipe identification -->
            <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_id); ?>">
        </form>
    </main>
</body>
</html>


<script>
document.getElementById('add-step').addEventListener('click', function() {
    const stepsContainer = document.getElementById('steps-container');
    const stepCount = stepsContainer.children.length + 1;
    
    const newStep = document.createElement('div');
    newStep.className = 'step-card';
    newStep.innerHTML = `
        <div class='step-content'>
            <h3>Step ${stepCount}</h3>
            <textarea name='step_instructions[]' class='step-instructions'></textarea>
            <div class='step-image-upload'>
                <label class='file-upload-label'>
                    <input type='file' name='step_image[]' accept='image/*' onchange='previewStepImage(this)'>
                </label>
                <span class='upload-status text'></span>
            </div>
        </div>
        <div class='step-image-container'>
            <img class='step-image' src='Images/not-found.jpg' alt='Step ${stepCount} image'>
        </div>
    `;
    
    stepsContainer.appendChild(newStep);
});

function showUploadSuccess(input) {
    const statusSpan = input.parentElement.nextElementSibling;
    if (input.files && input.files[0]) {
        statusSpan.textContent = "Upload successful!";
        statusSpan.style.color = "var(--text-color)";
        // Clear the message after 3 seconds
        setTimeout(() => {
            statusSpan.textContent = "";
        }, 3000);
    }
}

// Update existing file inputs to use the success message
document.addEventListener('DOMContentLoaded', function() {
    const existingInputs = document.querySelectorAll('input[type="file"]');
    existingInputs.forEach(input => {
        input.setAttribute('onchange', 'showUploadSuccess(this)');
        // Add status span if it doesn't exist
        if (!input.parentElement.nextElementSibling?.classList.contains('upload-status')) {
            const statusSpan = document.createElement('span');
            statusSpan.className = 'upload-status text';
            input.parentElement.parentNode.insertBefore(statusSpan, input.parentElement.nextSibling);
        }
    });
});

function confirmDelete() {
    if (confirm('Are you sure you want to delete this recipe?')) {
        const recipeId = document.querySelector('input[name="recipe_id"]').value;
        
        // Create form for POST request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'delete_recipe.php';
        
        // Add recipe ID
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'recipe_id';
        input.value = recipeId;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

document.querySelector('input[name="main_image"]').addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.recipe-main-image').src = e.target.result;
        };
        reader.readAsDataURL(this.files[0]);
    }
});

function previewStepImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Find the closest step-image element within this step
            const previewImg = input.closest('.step-card').querySelector('.step-image');
            if (previewImg) {
                previewImg.src = e.target.result;
            } else {
                // If no image exists yet, create one
                const imageContainer = document.createElement('div');
                imageContainer.className = 'step-image-container';
                const newImage = document.createElement('img');
                newImage.className = 'step-image';
                newImage.src = e.target.result;
                newImage.alt = 'Step image';
                imageContainer.appendChild(newImage);
                input.closest('.step-card').appendChild(imageContainer);
            }
        };
        reader.readAsDataURL(input.files[0]);
        
        // Keep the existing upload success message
        showUploadSuccess(input);
    }
}

// Update existing file inputs to use the preview function
document.addEventListener('DOMContentLoaded', function() {
    const stepImageInputs = document.querySelectorAll('input[name="step_image[]"]');
    stepImageInputs.forEach(input => {
        input.setAttribute('onchange', 'previewStepImage(this)');
    });
});
</script>
