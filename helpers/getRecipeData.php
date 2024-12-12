<?php
require '../database/db_connect.php';

try {
    // Query the database for all recipe servings data to use globally in app
    $stmt = $conn->prepare("
        SELECT recipe_id, servings, ingredients
        FROM recipes
    ");
    
    $stmt->execute();

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the recipes as JSON object, will be decoded into a PHP object in recipeAdjuctment.js
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
