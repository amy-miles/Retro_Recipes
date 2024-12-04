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
    <!--CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">


</head>

<body>

    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <div class="container col-xxl-8 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <img src="assets/hero_image.png" class="d-block mx-lg-auto mt-5 img-fluid" alt="Housewives Cooking" width="400" height="auto" loading="lazy">
            </div>
            <div class="col-lg-6">
                <img src="assets/inline_logo.png" class="mx-lg-auto img-fluid" width="350" height="auto">

                <h4 class="text-body-emphasis lh-1 mb-3">Family Recipes from the Olden Days</h4>
                <p class="lead">Celery in jello? Raisins in meatloaf? </br>Share or browse the strange world of retro recipes. </p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 me-md-2">View Recipes</button>
                    <button type="button" class="btn btn-outline-secondary btn-lg px-4">Add a Recipe</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recipe Content -->
    <div class="custom-background py-5">
        <div class="container">
            <!-- Content inside white div -->
            <div id="recipe_display_div" class="content-box p-4">
                <!-- Content dynamically populated from the database -->
                <h1>Dynamically populate the recipes here.</h1>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>