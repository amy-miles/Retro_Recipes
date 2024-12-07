<?php
session_start(); // Start the session

$validUser = false; // Default: Not a valid user
$errorMsg = "";    // Default: No error message

if (isset($_SESSION['validSession']) && $_SESSION['validSession'] === "yes") {
    $validUser = true; // User already logged in
} else {
    if (isset($_POST['submit'])) {
        $inUsername = $_POST['inUsername'];
        $inPassword = $_POST['inPassword'];

        try {
            require 'database/db_connect.php'; // Database connection

            // Updated SQL to fetch user_id
            $sql = "SELECT user_id FROM users WHERE user_username = :username AND user_password = :password";

            // Prepare the statement
            $stmt = $conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':username', $inUsername);
            $stmt->bindParam(':password', $inPassword);

            $stmt->execute();

            // Fetch user_id if a match is found
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Valid login
                $validUser = true;
                $_SESSION['validSession'] = "yes"; // Mark session as valid
                $_SESSION['user_id'] = $user['user_id']; // Store user_id in session
            } else {
                // Invalid login
                $validUser = false;
                $errorMsg = "Invalid username and/or password. Please try again.";
                $_SESSION['validSession'] = "no";
            }
        } catch (PDOException $e) {
            echo "Database Failed: " . $e->getMessage();
        }
    }
}

if ($validUser === true) {
    header("Location: userPage.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">

    <Style>
        .loginErrorDiv {
            color: red;
            font-style: italic;
        }
    </Style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>


    <?php
    if (isset($_POST['submit']) && $validUser === true) {
        //display admin or maybe redirect to the user's page
        echo "Redirecting to userPage.php...";
        header("Location:userPage.php");

    ?>
    <?php
    } else {
        //display form

    ?>
        <section class="custom-background py-5">
            <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
                <!-- Form Box -->
                <div class="content-box p-4">
                    <h1 class="text-center retro-header">Login Form</h1>
                    <form method="post" action="login.php" class="mt-3">
                        <!-- Error Message -->
                        <div class="loginErrorDiv text-danger text-center mb-3">
                            <?php
                            if (isset($errorMsg)) // Display the error message if set
                                echo $errorMsg;
                            ?>
                        </div>
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="inUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" name="inUsername" id="inUsername" placeholder="Enter your username" required>
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="inPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="inPassword" id="inPassword" placeholder="Enter your password" required>
                        </div>
                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    <?php
    }   //end of else branch    
    ?>
    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>