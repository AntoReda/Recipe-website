<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: redirect.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Recipe</title>
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

        function handleKeyPress(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                var textarea = event.target;
                var currentText = textarea.value;
                var cursorPosition = textarea.selectionStart;
                var updatedText = currentText.slice(0, cursorPosition) + '\n• ' + currentText.slice(cursorPosition);
                textarea.value = updatedText;
                textarea.selectionStart = textarea.selectionEnd = cursorPosition + 2;
                textarea.dispatchEvent(new Event('input'));
            }
        }
    </script>
</head>
<body id="background">
<?php include 'loading_spinner.php'; ?>
<?php include 'navbar.php'; ?>
    <main>
        <div id="recipe-page" class="displayChange">
            <form accept-charset="UTF-8" action="process_recipe.php" method="post" enctype="multipart/form-data">
                <div class="recipe-header">
                    <div class="recipe-title-edit">
                        <p class="Heading1">Recipe Name:</p>
                        <input type="text" 
                               name="INrecipeName" 
                               class="text Heading2" 
                               required 
                               oninvalid="this.setCustomValidity('Please enter a recipe name')"
                               oninput="this.setCustomValidity('')"
                               placeholder="Enter recipe name">
                    </div>
                    <div class="recipe-metadata">
                        <div class="metadata-field">
                            <label class="text">Duration (minutes):</label>
                            <input type="number" 
                                   name="duration" 
                                   step="0.1" 
                                   min="0" 
                                   class="text"
                                   required
                                   placeholder="Enter duration">
                        </div>
                        <div class="metadata-field">
                            <label class="text">Portions:</label>
                            <input type="number" 
                                   name="portions" 
                                   step="0.1" 
                                   min="0" 
                                   class="text"
                                   required
                                   placeholder="Enter portions">
                        </div>
                    </div>
                    <div class="header-buttons">
                        <button type="submit" name="submit" class="text">Submit Recipe</button>
                    </div>
                </div>

                <!-- Left Side -->
                <div style="float: left; width: 45%;">
                    <div class="recipe-main-info">
                        <div class="recipe-image-container">
                            <img id="recipeInstructionsLogo" src="Images/not-found.jpg" alt="Recipe Image">
                            <div class="image-upload">
                                <p class="Heading2">Add Main Image</p>
                                <label class="file-upload-label">
                                    <input type="file" name="INrecipeImage" accept="image/*" onchange="showUploadSuccess(this)">
                                </label>
                                <span class="upload-status text"></span>
                            </div>
                        </div>
                        
                        <div class="IngredientsBox">
                            <p class="Heading1">Ingredients</p>
                            <textarea name="INrecipeIngredients" class="text Heading2" required></textarea>
                        </div>

                        <div class="recipe-category">
                            <p class="Heading2">Food Category:</p>
                            <select id="dropdown" name="type" class="text">
                                <option value="meats">Meat</option>
                                <option value="fish">Fish</option>
                                <option value="veggies">Veggie</option>
                                <option value="pastas">Pasta</option>
                                <option value="sandwiches">Sandwich</option>
                                <option value="soups">Soups</option>
                                <option value="desserts">Desserts</option>
                                <option value="others">Other</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Right Side -->
                <div style="float: right; width: 45%;">
                    <div class="InstructionsBox">
                        <p class="Heading1">Instructions:</p>
                        <div id="steps-container">
                            <div class="recipe-step">
                                <div class="step-content">
                                    <p class="Heading2">Step 1</p>
                                    <img class="step-preview-image" src="Images/not-found.jpg" alt="Step 1 Image" style="max-width: 200px; margin: 10px 0;">
                                    <textarea name="step_instructions[]" class="text Heading2" required></textarea>
                                    <label class="file-upload-label">
                                        <input type="file" name="step_image[]" accept="image/*" onchange="previewStepImage(this)">
                                    </label>
                                    <span class="upload-status text"></span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-step" class="text">Add Step</button>
                    </div>
                </div>

                <div style="clear: both;"></div>

                <div class="bottom-buttons">
                    <button type="submit" name="submit" class="text">Submit Recipe</button>
                </div>
            </form>
        </div>
    </main>

    <script>
    document.getElementById('add-step').addEventListener('click', function() {
        const stepsContainer = document.getElementById('steps-container');
        const stepCount = stepsContainer.children.length;
        
        const newStep = document.createElement('div');
        newStep.className = 'recipe-step';
        newStep.innerHTML = `
            <div class='step-content'>
                <p class='Heading2'>Step ${stepCount + 1}</p>
                <img class="step-preview-image" src="Images/not-found.jpg" alt="Step ${stepCount + 1} Image" style="max-width: 200px; margin: 10px 0;">
                <textarea name='step_instructions[]' class='text Heading2' required></textarea>
                <label class='file-upload-label'>
                    <input type='file' name='step_image[]' accept='image/*' onchange='previewStepImage(this)'>
                </label>
                <span class='upload-status text'></span>
            </div>
        `;
        
        stepsContainer.appendChild(newStep);
    });

    function previewStepImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Find the closest step-preview-image element within this step
                const previewImg = input.closest('.step-content').querySelector('.step-preview-image');
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            
            // Keep the existing upload success message
            showUploadSuccess(input);
        }
    }

    function showUploadSuccess(input) {
        const statusSpan = input.parentElement.nextElementSibling;
        if (input.files && input.files[0]) {
            statusSpan.textContent = "Upload successful!";
            statusSpan.style.color = "var(--text-color)";
            setTimeout(() => {
                statusSpan.textContent = "";
            }, 3000);
        }
    }

    // Preview main image when selected
    document.querySelector('input[name="INrecipeImage"]').addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('recipeInstructionsLogo').src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        }
    });
    </script>

    <style>
        .ingredient-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .small-btn {
            padding: 0 10px;
            height: 30px;
            min-width: 30px;
        }
        .step {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        textarea {
            width: 100%;
            min-height: 100px;
            margin: 10px 0;
        }
    </style>
</body>
</html>