<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add a Recipe</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">
</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Content -->
    <div class="custom-background py-5">
        <div class="container d-flex justify-content-center">
            <div class="recipe-upload-container shadow-lg p-5 bg-white rounded">
                <h1 class="text-center mb-4">Add a Recipe</h1>
                <form action="uploadRecipe.php" method="POST" enctype="multipart/form-data">

                    <!-- Recipe Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Recipe Title:</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter recipe title">
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <select name="category" id="category" class="form-select">
                            <option value="" selected disabled>Select a category</option>
                            <option value="Appetizers">Appetizers</option>
                            <option value="Beverages">Beverages</option>
                            <option value="Desserts">Desserts</option>
                            <option value="Main">Main</option>
                            <option value="Sides">Sides</option>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty:</label>
                        <select name="difficulty" id="difficulty" class="form-select" required>
                            <option value="default" selected>Select Difficulty</option>
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                        </select>
                    </div>


                    <!-- Recipe Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Recipe Image:</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <!-- Servings -->
                    <div class="mb-3">
                        <label for="servings" class="form-label">Servings:</label>
                        <input type="number" name="servings" id="servings" class="form-control" placeholder="Enter the number of servings" min="1" required>
                    </div>


                    <!-- Ingredients -->
                    <h3>Ingredients</h3>
                    <div id="ingredients-container" class="mb-3">
                        <div class="row g-2 align-items-center mb-2">
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
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" onclick="addIngredient()">Add Another Ingredient</button>

                    <!-- Instructions -->
                    <h3>Instructions</h3>
                    <div id="instructions-container" class="mb-3">
                        <div class="mb-2">
                            <textarea name="steps[]" class="form-control mb-2" rows="2" placeholder="Step 1"></textarea>
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeStep(this)">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" onclick="addStep()">Add Another Step</button>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">Upload Recipe</button>
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