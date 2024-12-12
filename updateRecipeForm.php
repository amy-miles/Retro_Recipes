<?php
ini_set('session.cookie_lifetime', 0); //to destroy session cookie if browser is closed
session_start();
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    // Redirect to login page
    header("Location: login.php");
    exit;
}
?>
<?php
$recipe_id = $_GET['recipe_id'] ?? null;

try {
    require 'database/db_connect.php'; //access to the database

    //Pass the desired record
    $sql = "SELECT * FROM recipes WHERE recipe_id = :recipe_id"; // named parameter
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':recipe_id', $recipe_id);

    $stmt->execute(); //Exacute the PDO Prepared stamt, save results in $stmt object

    $stmt->setFetchMode(PDO::FETCH_ASSOC); //return values as an ASSOC array

    //fetch all into a record
    $recipeRecord = $stmt->fetch();

    //assign all columns to a variable

    $category = $recipeRecord["category"];
    $title = $recipeRecord["title"];
    $instructionsArray = json_decode($recipeRecord["instructions"], true);//php objects
    $ingredientsArray = json_decode($recipeRecord["ingredients"], true);
    $image = $recipeRecord["image"];
    $servings = $recipeRecord["servings"];
    $difficulty = $recipeRecord["difficulty"];
} catch (PDOException $e) {
    echo "Database Failed" . $e->getMessage();
}
?>
<!-- Amy Miles 
WDV 341 & WDV 321 Final Project -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update a Recipe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">

    <script>
        function validateForm() {
            let isValid = true;
            let errorMessage = "";

            // Reset previous error styles
            document.querySelectorAll(".error").forEach(el => el.classList.remove("error"));

            // Validate Title
            const title = document.getElementById("title");
            if (title.value.trim() === "") {
                isValid = false;
                errorMessage += "Title is required.\n";
                title.classList.add("error");
            }

            // Validate Difficulty
            const difficulty = document.getElementById("difficulty");
            if (difficulty.value === "default") {
                isValid = false;
                errorMessage += "Please select a difficulty level.\n";
                difficulty.classList.add("error");
            }

            // Validate Servings
            const servings = document.getElementById("servings");
            if (!servings.value || servings.value <= 0) {
                isValid = false;
                errorMessage += "Please enter a valid number for servings (greater than 0).\n";
                servings.classList.add("error");
            }

            // Validate Ingredients
            const ingredients = document.querySelectorAll("#ingredients-container .row");
            if (ingredients.length === 0) {
                isValid = false;
                errorMessage += "At least one ingredient is required.\n";
                document.getElementById("ingredients-container").classList.add("error");
            }

            // Validate Steps
            const steps = document.querySelectorAll("#instructions-container textarea");
            if (steps.length === 0 || steps[0].value.trim() === "") {
                isValid = false;
                errorMessage += "At least one instruction step is required.\n";
                document.getElementById("instructions-container").classList.add("error");
            }

            // Show errors and prevent form submission
            if (!isValid) {
                alert(errorMessage);
            }

            return isValid;
        }
    </script>
    <style>
        .error {
            border: 2px solid red;
            background-color: #ffe6e6;
        }
    </style>




</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Content -->
    <div class="custom-background py-5">
        <div class="container d-flex justify-content-center">
            <div class="recipe-upload-container shadow-lg p-5 bg-white rounded">
                <h1 class="text-center mb-4 display-2 retro-header">Update a Recipe</h1>
                <form action="updateRecipe.php?recipe_id=<?php echo $recipe_id; ?>" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">

                    <div class="invisible">
                        <label for="description">Description:</label>
                        <input type="text" name="description" id="description" />
                    </div>

                    <!-- Recipe Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Recipe Title:</label>
                        <input type="text" name="title" id="title" class="form-control" value="<?php echo $title; ?>" placeholder="Enter recipe title">
                    </div>

                    <!-- Category -->
                    <!-- Using a conditional variable to set the user's selected category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select name="category" id="category" class="form-select">
                            <option value="" selected disabled>Select a category</option>
                            <option value="Appetizers" <?php echo ($category == "Appetizers") ? 'selected' : ''; ?>>Appetizers</option>
                            <option value="Beverages" <?php echo ($category == "Beverages") ? 'selected' : ''; ?>>Beverages</option>
                            <option value="Desserts" <?php echo ($category == "Desserts") ? 'selected' : ''; ?>>Desserts</option>
                            <option value="Main" <?php echo ($category == "Main") ? 'selected' : ''; ?>>Main</option>
                            <option value="Sides" <?php echo ($category == "Sides") ? 'selected' : ''; ?>>Sides</option>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <select name="difficulty" id="difficulty" class="form-select" required>
                            <option value="default" selected disabled>Select Difficulty</option>
                            <option value="Easy" <?php echo ($difficulty == "Easy") ? 'selected' : ''; ?>>Easy</option>
                            <option value="Medium" <?php echo ($difficulty == "Medium") ? 'selected' : ''; ?>>Medium</option>
                            <option value="Hard" <?php echo ($difficulty == "Hard") ? 'selected' : ''; ?>>Hard</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="image" class="form-label">Recipe Image:</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <!-- Display the current image -->
                        <div class="mt-2">
                            <p>Current image:</p>
                            <img src="uploads/<?php echo $image; ?>" alt="Current Recipe Image" style="max-width: 200px; height: auto;">
                        </div>
                        <input type="hidden" name="existing_image" value="<?php echo $image; ?>">
                    </div>

                    <!-- Servings -->
                    <div class="mb-3">
                        <label for="servings" class="form-label">Servings:</label>
                        <input type="number" name="servings" id="servings" value="<?php echo $servings; ?>" class="form-control" placeholder="Enter the number of servings" min="1" required>
                    </div>


                    <!-- Ingredients -->
                    <h3>Ingredients</h3>
                    <div id="ingredients-container" class="mb-3">
                        <h3>Ingredients</h3>
                        <?php if (!empty($ingredientsArray)) : ?>
                            <?php foreach ($ingredientsArray as $ingredient): ?>
                                <div class="row g-2 align-items-center mb-2">
                                    <div class="col-3">
                                        <input type="text" name="amount[]" class="form-control" placeholder="Amount"
                                            value="<?php echo $ingredient['amount']; ?>">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" name="unit[]" class="form-control" placeholder="Unit"
                                            value="<?php echo $ingredient['unit']; ?>">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" name="name[]" class="form-control" placeholder="Ingredient Name"
                                            value="<?php echo $ingredient['name']; ?>">
                                    </div>
                                    <div class="col-2 text-end">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeIngredient(this)">Remove</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="btn btn-primary mb-3" onclick="addIngredient()">Add Another Ingredient</button>

                    <!-- Instructions -->
                    <h3>Instructions</h3>
                    <div id="instructions-container" class="mb-3">
                        <?php if (!empty($instructionsArray)) : ?>
                            <?php foreach ($instructionsArray as $index => $instruction): ?>
                                <div class="mb-2">
                                    <!-- Populate each instruction -->
                                    <textarea name="steps[]" class="form-control mb-2" rows="2" placeholder="Step <?php echo $instruction['step']; ?>">
<?php echo $instruction['instruction']; ?>
</textarea>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">Remove</button>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="mb-2">
                                <textarea name="steps[]" class="form-control mb-2" rows="2" placeholder="Step 1"></textarea>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">Remove</button>
                            </div>
                        <?php endif; ?>
                    </div>


                    <button type="button" class="btn btn-primary mb-3" onclick="addStep()">Add Another Step</button>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Update Recipe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script>
        function addIngredient() {
            const container = document.getElementById("ingredients-container");
            const newIngredient = document.createElement("div");
            newIngredient.className = "row g-2 align-items-center mb-2";
            newIngredient.innerHTML = `
                <div class="col-3">
                    <input type="text" name="amount[]" class="form-control" placeholder="Amount">
                </div>
                <div class="col-3">
                    <input type="text" name="unit[]" class="form-control" placeholder="Unit">
                </div>
                <div class="col-4">
                    <input type="text" name="name[]" class="form-control" placeholder="Ingredient Name">
                </div>
                <div class="col-2 text-end">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removeIngredient(this)">Remove</button>
                </div>`;
            container.appendChild(newIngredient);
        }

        function removeIngredient(button) {
            button.parentElement.parentElement.remove();
        }

        function addStep() {
            const container = document.getElementById("instructions-container");
            const stepNumber = container.children.length + 1;
            const newStep = document.createElement("div");
            newStep.className = "mb-2";
            newStep.innerHTML = `
                <textarea name="steps[]" class="form-control mb-2" rows="2" placeholder="Step ${stepNumber}"></textarea>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">Remove</button>`;
            container.appendChild(newStep);
        }

        function removeStep(button) {
            button.parentElement.remove();
            const steps = document.querySelectorAll("#instructions-container textarea");
            steps.forEach((textarea, index) => {
                textarea.placeholder = `Step ${index + 1}`;
            });
        }
    </script>
</body>

</html>