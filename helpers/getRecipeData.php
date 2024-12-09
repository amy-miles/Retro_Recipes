<?php
require '../database/db_connect.php';


try {
    // Query the database for the user's recipes
    $stmt = $conn->prepare("
        SELECT recipe_id, servings, ingredients
        FROM recipes
    ");
    
    $stmt->execute();

    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the recipes as JSON
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
