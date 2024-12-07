<?php
require 'database/db_connect.php';

if (isset($_GET['recipe_id'])) {
    $recipe_id = (int)$_GET['recipe_id']; // Sanitize input
    
    try {
        // Delete the recipe
        $stmt = $conn->prepare("DELETE FROM recipes WHERE recipe_id = :recipe_id");
        $stmt->bindParam(':recipe_id', $recipe_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: userPage.php?message=Recipe+Deleted+Successfully");
        } else {
            // Redirect with error message
            header("Location: userPage.php?error=Failed+to+Delete+Recipe");
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Redirect back if no recipe_id is provided
    header("Location: userPage.php?error=Invalid+Request");
}
?>
