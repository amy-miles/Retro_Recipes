<?php
// Access to Database
require 'database/db_connect.php';

ini_set('session.cookie_lifetime', 0);
session_start();
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id']; // Retrieve user_id from session
$first_name= $_SESSION['first_name']; // Retrieve the first name of user
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Recipes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">

    <!-- Logic for 'Servings' adjustments and functionality -->
    <script src="js/fractionHelper.js"></script>
    <script src="js/recipeAdjustments.js"></script>

    <!-- Delete recipe function -->
    <script>
        function confirmDelete(recipeId, recipeTitle) {
            if (confirm(`Are you sure you want to delete the recipe "${recipeTitle}"? This action cannot be undone.`)) {
                window.location.href = `deleteRecipe.php?recipe_id=${recipeId}`;
            }
        }
    </script>

</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="assets/hero_image.png" class="d-block mx-lg-auto mt-5 img-fluid" alt="Housewives Cooking" width="400" height="auto" loading="lazy">
            </div>
            <div class="col-lg-6 d-flex flex-column align-items-center text-center">
                <p>
                    <img src="assets/my_recipes_logo.png" class="img-fluid" width="350" height="auto">
                </p>
                <?php echo '<h2 class="mt-5">Hello ' . $first_name . '!</h2>'; ?>
                <div class="d-grid gap-2">
                    <a href="addRecipeForm.php" class="btn btn-outline-secondary btn-lg px-4">
                        Add a Recipe
                    </a>
                </div>
            </div>

        </div>
    </div>

    <!-- Recipe Content -->
    <div class="custom-background py-5">
        <div class="container d-flex justify-content-center">
            <div id="recipe_display_div" class="content-box p-4">
                <?php
                try {
                    // Fetch all recipes grouped by category
                    $stmt = $conn->prepare("SELECT recipe_id, title, category, image, ingredients, instructions, difficulty, servings 
                    FROM recipes 
                    WHERE user_id = :user_id 
                    ORDER BY category, title");

                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();
                    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Check if there are any recipes
                    if (empty($recipes)) {
                        // Display default message if no recipes
                        echo '<div class="alert alert-info text-center">
                                <h4>You don\'t have any recipes yet!</h4>
                                <p>Start by adding your first recipe.</p>
                                <a href="addRecipeForm.php" class="btn btn-primary mt-3">Add Your First Recipe</a>
                              </div>';
                    } else {
                        // Group recipes by category
                        $groupedRecipes = [];
                        foreach ($recipes as $recipe) {
                            $groupedRecipes[$recipe['category']][] = $recipe;
                        }

                        // Loop through each category
                        foreach ($groupedRecipes as $category => $recipes) {
                            echo '<h2 class="mt-5 display-3 retro-header">' . htmlspecialchars($category) . '</h2>';
                            echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';

                            // Loop through recipes in the current category
                            foreach ($recipes as $recipe) {
                                $recipeId = $recipe['recipe_id'];
                                $title = htmlspecialchars($recipe['title']);
                                $image = htmlspecialchars($recipe['image']);
                                $ingredients = json_decode($recipe['ingredients'], true);
                                $instructions = json_decode($recipe['instructions'], true);
                                $difficulty = $recipe['difficulty'];
                                $servings = $recipe['servings'];

                                echo '
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="uploads/' . $image . '" class="card-img-top recipe-image" alt="' . $title . '">
                                        <div class="card-body">
                                            <h5 class="card-title">' . $title . '</h5>
                                            <p class="text-muted mb-1" style="font-size: 0.9em;">Difficulty: ' . $difficulty . '</p>
                                            <p class="text-muted mb-2" style="font-size: 0.9em;">
                                                Servings: <span id="servings-' . $recipeId . '">' . $servings . '</span>
                                                <a href="javascript:void(0);" onclick="adjustRecipe(' . $recipeId . ', 0.5)" class="small text-primary float-end ms-2">1/2x</a>
                                                <a href="javascript:void(0);" onclick="adjustRecipe(' . $recipeId . ', 2)" class="small text-primary float-end ms-2">2x</a>
                                                <a href="javascript:void(0);" onclick="resetRecipe(' . $recipeId . ')" class="small text-danger float-end ms-2">Reset</a>
                                            </p>
                                            <div class="d-flex flex-column gap-2">
                                                <button class="btn btn-success btn-sm" onclick="toggleDetails(' . $recipeId . ')">View Recipe</button>
                                                <a href="updateRecipeForm.php?recipe_id=' . $recipeId . '" class="btn btn-primary btn-sm">Update Recipe</a>
                                                <button class="btn btn-danger btn-sm" onclick="confirmDelete(' . $recipeId . ', \'' . $title . '\')">Delete Recipe</button>
                                            </div>
                                            <div class="details mt-3" id="details-' . $recipeId . '" style="display: none;">
                                                <h6>Ingredients:</h6>
                                                <ul>';
                                foreach ($ingredients as $ingredient) {
                                    echo '<li>' . htmlspecialchars($ingredient['amount']) . ' ' . htmlspecialchars($ingredient['unit']) . ' ' . htmlspecialchars($ingredient['name']) . '</li>';
                                }
                                echo '</ul>
                                                <h6>Instructions:</h6>
                                                <ol>';
                                foreach ($instructions as $step) {
                                    echo '<li>' . htmlspecialchars($step['instruction']) . '</li>';
                                }
                                echo '</ol>
                                                <button class="btn btn-secondary" onclick="toggleDetails(' . $recipeId . ')">Hide Recipe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }

                            echo '</div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo '<p>Error fetching recipes: ' . $e->getMessage() . '</p>';
                }
                ?>
            </div>
        </div>
    </div> <!--end recipe content -->

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle the visibility of recipe details
        function toggleDetails(recipeId) {
            const details = document.getElementById(`details-${recipeId}`);
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block'; // Show the details
            } else {
                details.style.display = 'none'; // Hide the details
            }
        }
    </script>
</body>

</html>
