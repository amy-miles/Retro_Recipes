<?php
session_start();
$responseMessage = isset($_SESSION['responseMessage']) ? $_SESSION['responseMessage'] : "No message available.";
unset($_SESSION['responseMessage']); // Clear the session variable
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link rel="icon" href="assets/icon.png" type="image/png">

    <Style>
  
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

        .btn-primary {
            background-color: #ff69b4; /* Custom background color */
            border-color: #ff69b4;    /* Custom border color */
            color: white;             /* Custom text color */
            border-radius: 15px;
        }

    </Style>

</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    <form>
    <legend class="text-center display-3 retro-header">Contact Response</legend>
    
    <div class="mt-5">
        <div class="alert <?php echo (strpos($responseMessage, 'successfully') !== false) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
            
            <?php echo $responseMessage; ?>
        </div>
    </div>
    </form>
    <?php include 'includes/footer.php'; ?>    
</body>
</html>
