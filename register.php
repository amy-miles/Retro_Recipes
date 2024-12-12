<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Bundle JS (with Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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

        #first_name,
        #username,
        #password,
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

    <form method="POST" action="register.php">
    <legend class="retro-header display-2">Register</legend>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <p>
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" pattern="[A-Za-z]+" title="Only letters are allowed." placeholder="Enter your first name." required>
        </p>
        <p>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" minlength="4" maxlength="20" placeholder="Enter your username." required>
        </p>
        <p>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" minlength="6" placeholder="Enter your password." required>
        </p>
        <p>
            <button type="submit" class="btn btn-primary">Register</button>
            <input type="reset" class="btn btn-outline-primary" id="button2" value="Reset">
        </p>
    </form>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>
