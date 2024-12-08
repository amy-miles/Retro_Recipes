<?php
require '../database/db_connect.php';

session_start();

// Check if the user is authenticated
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "Unauthorized access"]);
    exit;
}

$user_id = $_SESSION['user_id']; // Retrieve user ID from session

try {
    // Query the database for the user's recipes
    $stmt = $conn->prepare("
        SELECT recipe_id, servings, ingredients
        FROM recipes
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the recipes as JSON
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
