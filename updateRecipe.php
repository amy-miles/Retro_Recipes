<?php
// Honeypot check
$description = $_POST['description']; 
if ($description !== "") {
    die("This will not process the form.");
}

require 'database/db_connect.php';

ini_set('session.cookie_lifetime', 0); // Destroy session cookie if browser is closed
session_start();
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    header("Location: login.php");
    exit;
}

// Retrieve the recipe ID from the query string
$recipe_id = $_GET['recipe_id'] ?? null;

// Process the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gather form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $servings = $_POST['servings'];
    $difficulty = $_POST['difficulty'];
    $amounts = $_POST['amount'];
    $units = $_POST['unit'];
    $names = $_POST['name'];
    $steps = $_POST['steps'];
    $image = $_FILES['image'];

    // Set the default image name
    $defaultImageName = 'default_recipe_image.jpg';
    $imageName = $defaultImageName; 

    // This will retain the original image if no new image is uploaded
    if (isset($_POST['existing_image']) && !empty($_POST['existing_image'])) {
        $imageName = $_POST['existing_image'];
    }

    // Process the uploaded image
    if (isset($image['name']) && $image['name'] !== '') {
        $targetDir = "uploads/";
        $uploadedImageName = basename($image['name']);
        $targetFile = $targetDir . $uploadedImageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            $imageName = $uploadedImageName; 
        } else {
            die("Failed to upload new image.");
        }
    }


    // Convert ingredients to JSON
    $ingredients = [];
    foreach ($names as $index => $name) {
        $ingredients[] = [
            "amount" => $amounts[$index],
            "unit" => $units[$index],
            "name" => $name
        ];
    }
    $ingredientsJson = json_encode($ingredients);

    // Convert instructions to JSON
    $instructions = [];
    foreach ($steps as $index => $step) {
        $instructions[] = ["step" => $index + 1, "instruction" => $step];
    }
    $instructionsJson = json_encode($instructions);

    // Prepare the SQL update statement
    $stmt = $conn->prepare("
        UPDATE recipes 
        SET 
            category = :category, 
            title = :title, 
            servings = :servings, 
            difficulty = :difficulty, 
            instructions = :instructions, 
            ingredients = :ingredients, 
            image = :image, 
            updated_at = NOW()
        WHERE recipe_id = :recipe_id
    ");

    // Bind parameters
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':servings', $servings);
    $stmt->bindParam(':difficulty', $difficulty);
    $stmt->bindParam(':instructions', $instructionsJson);
    $stmt->bindParam(':ingredients', $ingredientsJson);
    $stmt->bindParam(':image', $imageName);
    $stmt->bindParam(':recipe_id', $recipe_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Recipe updated successfully!";
        header("Location: userPage.php");
        exit;
    } else {
        echo "Error: Unable to execute query.";
    }
}
?>
