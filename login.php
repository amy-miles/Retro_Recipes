<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Browser Icon -->
    <link rel="icon" href="assets/icon.png" type="image/png">

    <style>
        form {
            width: 90%;
            max-width: 400px;
            margin: auto;
            background-color: #eeb4d9;
            padding: 20px;
            border-radius: 15px;
            font-family: 'Calibri', sans-serif;
            color: dimgray;
        }

        form legend {
            font-size: larger;
            text-align: center;
        }

        #inUsername,
        #inPassword,
        #button2 {
            padding: 5px;
            border: 1px solid #ff69b4;
            border-radius: 15px;
        }

        .btn-primary {
            background-color: #ff69b4; /* Custom background color */
            border-color: #ff69b4;    /* Custom border color */
            color: white;             /* Custom text color */
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <form method="post" action="login.php">
        <legend class="retro-header display-2">Login</legend>
        <?php if (isset($errorMsg)): ?>
            <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
        <?php endif; ?>
        <p>
            <label for="inUsername">Username:</label>
            <input type="text" id="inUsername" name="inUsername" placeholder="Enter your username" required>
        </p>
        <p>
            <label for="inPassword">Password:</label>
            <input type="password" id="inPassword" name="inPassword" placeholder="Enter your password" required>
        </p>
        <p>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <input type="reset" class="btn btn-outline-primary" id="button2" value="Reset">
        </p>
    </form>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
