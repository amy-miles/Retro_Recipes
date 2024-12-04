<?php

session_start(); // This will not create a PHPSESSID cookie
//echo "Session Value: " . ($_SESSION['validSession'] ?? 'Not Set'); // Debugging
//$errorMsg = ""; //option 1 define the global scope variable


if (isset($_SESSION['validSession']) && $_SESSION['validSession'] === "yes"){
    //echo "Session is valid, displaying admin area.";
    //if you are a 'validSession' then you should see the admin page
    //you do not need to sign on again. we will keep you signed on
    $validUser = true; //set flag for Valid user to display the admin page

} 
else {
    //you need to sign on

    if (isset($_POST['submit'])) {
        //the form was submitted, continue processing the form data
        /*
        get the data from the form
        connect to the database
        see if you have a mathcing record in the users table
        if match = true
            valid user
            display admin page

        else 
            invalid user
            display error message
            display the form
        */

        $inUsername = $_POST['inUsername'];
        $inPassword = $_POST['inPassword'];

        try {
            //access database
            require 'db_connect.php'; //access to the database

            //SQL statment
            // $sql = "SELECT user_username, user_username FROM wdv341_users WHERE user_username = :username 
            // AND user_password = :password";

            $sql = "SELECT COUNT(*) FROM wdv341_users WHERE user_username = :username 
        AND user_password = :password";


            // Prepare
            $stmt = $conn->prepare($sql);

            //bind parameters
            $stmt->bindParam(':username', $inUsername);
            $stmt->bindParam(':password', $inPassword);


            $stmt->execute(); //Exacute the PDO Prepared stamt, save results in $stmt object

            $rowCount = $stmt->fetchColumn(); //gets number of records 

            if ($rowCount > 0) {
                //valid username/passwrod
                //echo "<h3>Login Successful</h3>";
                $validUser = true; //switch or flag
                $_SESSION['validSession'] = "yes"; //set the session variable
            } else {
                //invalid username/password combo
                
                $validUser = false;
                $errorMsg = "Invalid username and/or password. Please try again.";
                $_SESSION['validSession'] = "no";
            }

            $stmt->setFetchMode(PDO::FETCH_ASSOC); //return values as an ASSOC array
        } catch (PDOException $e) {
            echo "Database Failed " . $e->getMessage();
        }
    } else {
        //cusotmoer neeeds to see th form in order to fill it out and submit it for sighon
    }
}// end of check for 'validSession'
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