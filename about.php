<!-- Amy Miles 
WDV 341 & WDV 321 Final Project -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">
    <!-- Bootstrap Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- About Section -->
    <section class="custom-background py-5 mt-5">
        <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
            <!-- About Box -->
            <div class="content-box-about p-5 w-75">
                <h2 class="text-center mb-4 retro-header display-2">About This Project</h2>
                <h5 class="text-center text-muted mb-4">
                    A Final Project Combining <strong>WDV 341 - PHP</strong> and <strong>WDV 321 - Advanced JavaScript</strong>
                </h5>
                <p>
                    This project, <strong>Retro Recipes</strong>, was created as an academic exercise to combine web development skills with a bit of culinary nostalgia. The goal of this project is to provide a platform where users can share and discover unique recipes, with a retro-inspired design to make it fun and visually appealing.
                </p>
                <a href="https://github.com/amy-miles/Retro_Recipes" target="_blank" class="btn btn-dark btn-sm mb-3">
                    <i class="bi bi-github"></i> View GitHub Code
                </a>
                <h4 class="mt-4">Features of Retro Recipes:</h4>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>User Accounts:</strong> Users can register, log in, and manage their own collection of recipes.
                    </li>
                    <li class="list-group-item">
                        <strong>Recipe Uploads:</strong> Share recipes with titles, categories, difficulty levels, and serving sizes. Users can also upload images and detailed instructions.
                    </li>
                    <li class="list-group-item">
                        <strong>Dynamic Adjustments:</strong> Recipes include a unique feature to scale servings up or down dynamically, adjusting ingredients proportionally.
                    </li>
                    <li class="list-group-item">
                        <strong>Categorized Display:</strong> Recipes are neatly organized by categories for easy browsing.
                    </li>
                    <li class="list-group-item">
                        <strong>Responsive Design:</strong> Built with a mobile-first approach to ensure accessibility across all devices.
                    </li>
                </ul>
                <h4 class="mt-4">Technologies Used:</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6><strong>Frontend:</strong></h6>
                        <ul>
                            <li>HTML, CSS, JavaScript</li>
                            <li>Bootstrap for styling and responsive layout</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><strong>Backend:</strong></h6>
                        <ul>
                            <li>PHP for server-side logic</li>
                            <li>MySQL for database management</li>
                        </ul>
                    </div>
                </div>
                <p class="mt-3">
                    <strong>Additional Features:</strong>
                    Google reCAPTCHA for form security, JSON for storing complex recipe details (e.g., ingredients and steps).
                </p>
                <h4 class="mt-4">Purpose of the Project:</h4>
                <p>
                    This project demonstrates:
                </p>
                <ul>
                    <li>The integration of client-side and server-side technologies.</li>
                    <li>Database management for dynamic content.</li>
                    <li>The ability to implement interactive and user-friendly web features.</li>
                </ul>
                <p class="text-center mt-4">
                    Thank you for visiting the site!
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
