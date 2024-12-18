<!-- Amy Miles 
WDV 341 & WDV 321 Final Project -->
<?php
session_start(); // Start the session

// Destroy all session data
$_SESSION = []; // Clear session variables
session_unset(); // Unset session variables
session_destroy(); // Destroy the session on the server

// Remove the session cookie from the browser via ChatGPT
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Disconnect from the database
$conn = null;

// Redirect to the home page
header("Location: index.php");
exit;
?>