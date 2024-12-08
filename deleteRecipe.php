<?php
require 'database/db_connect.php';

ini_set('session.cookie_lifetime', 0);//to destroy session cookie if browser is closed
session_start();
if (!isset($_SESSION['validSession']) || $_SESSION['validSession'] !== "yes") {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

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
