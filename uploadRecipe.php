<?php
// Access to Database
require 'database/db_connect.php';

ini_set('session.cookie_lifetime', 0);//to destroy session cookie if browser is closed
session_start();
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    // Redirect to login page
    header("Location: login.php");
    exit; // Stop further script execution
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id']; // Retrieve user_id from session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the logged-in user's ID from the session
    $user_id = 2; //hard coded for testing ($_SESSION['user_id'])

    // Get form data
    $title = $_POST['title'];
    $category = $_POST['category'];
    $servings = $_POST['servings'];
    $difficulty = $_POST['difficulty'];
    $amounts = $_POST['amount'];
    $units = $_POST['unit'];
    $names = $_POST['name'];
    $steps = $_POST['steps'];
    $image = $_FILES['image'];

    // Process the uploaded image
    $targetDir = "uploads/";
    $imageName = basename($image['name']);
    $targetFile = $targetDir . $imageName;
    if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
        die("Failed to upload image.");
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

    // Convert instructions to JSOn
    $instructions = [];
    foreach ($steps as $index => $step) {
        $instructions[] = ["step" => $index + 1, "instruction" => $step];
    }
    $instructionsJson = json_encode($instructions);

    // Prepare the SQL statement
    $stmt = $conn->prepare("
    INSERT INTO recipes (user_id, category, title, servings, difficulty, instructions, ingredients, image, created_at, updated_at)
    VALUES (:user_id, :category, :title, :servings, :difficulty, :instructions, :ingredients, :image, NOW(), NOW())
    ");


    // Bind parameters
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':servings', $servings, PDO::PARAM_INT);
    $stmt->bindParam(':difficulty', $difficulty, PDO::PARAM_STR);
    $stmt->bindParam(':instructions', $instructionsJson, PDO::PARAM_STR);
    $stmt->bindParam(':ingredients', $ingredientsJson, PDO::PARAM_STR);
    $stmt->bindParam(':image', $imageName, PDO::PARAM_STR);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Recipe uploaded successfully!";
        header("Location: userPage.php");
        exit;
    } else {
        echo "Error: Unable to execute query.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Recipe Upload Page</h1>
</body>

</html>