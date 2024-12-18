<?php
require 'database/db_connect.php';
?>
<!-- Amy Miles 
WDV 341 & WDV 321 Final Project -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
 
</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="container col-xl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="assets/hero_image.png" class="d-block mx-lg-auto mt-5 img-fluid" alt="Housewives Cooking" width="400" height="auto" loading="lazy">
            </div>
            <div class="col-lg-6">
                <img src="assets/inline_logo.png" class="mx-lg-auto img-fluid" width="350" height="auto">
                <h4 class="text-body-emphasis lh-1 mb-3">Family Recipes from the Olden Days</h4>
                <p class="lead">Celery in jello? Raisins in meatloaf? Bring it on! <br>Share or browse these wonderful recipes.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <a href="login.php" class="btn btn-outline-secondary btn-lg px-4">Add a Recipe</a>
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
                    $stmt = $conn->prepare("SELECT recipe_id, title, category, image, ingredients, instructions, servings, difficulty FROM recipes ORDER BY category, title");
                    $stmt->execute();
                    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $groupedRecipes = [];
                    foreach ($recipes as $recipe) {
                        $groupedRecipes[$recipe['category']][] = $recipe;
                    }

                    foreach ($groupedRecipes as $category => $recipes) {
                        echo '<h2 class="mt-5 display-3 retro-header">' . $category . '</h2>';
                        echo '<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">';

                        foreach ($recipes as $recipe) {
                            $recipeId = $recipe['recipe_id'];
                            $title = $recipe['title'];
                            $image = $recipe['image'];
                            $ingredients = json_decode($recipe['ingredients'], true);// Convert from JSON to PHP object
                            $instructions = json_decode($recipe['instructions'], true);// Convert from JSON to PHP object
                            $difficulty = ucfirst($recipe['difficulty']);
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
                                        <button class="btn btn-success btn-sm" onclick="toggleDetails(' . $recipeId . ')">View Recipe</button>
                                        <div class="details mt-3" id="details-' . $recipeId . '" style="display: none;">
                                            <h6>Ingredients:</h6>
                                            <ul>';
                            // loops through the php object 
                            foreach ($ingredients as $ingredient) {
                                echo '<li>' . $ingredient['amount'] . ' ' . $ingredient['unit'] . ' ' . $ingredient['name'] . '</li>';
                            }
                            echo '</ul>
                                            <h6>Instructions:</h6>
                                            <ol>';
                            foreach ($instructions as $step) {
                                echo '<li>' . $step['instruction'] . '</li>';
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
                } catch (PDOException $e) {
                    echo '<p>Error fetching recipes: ' . $e->getMessage() . '</p>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleDetails(recipeId) {
            const details = document.getElementById(`details-${recipeId}`);
            details.style.display = (details.style.display === 'none' || details.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>

</html>