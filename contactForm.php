<!-- Amy Miles 
WDV 341 & WDV 321 Final Project -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form with Email</title>

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

        #name,
        #email,
        #reason,
        #comments,
        form .g-recaptcha,
        #button2 {
            padding: 5px;
            border: 1px solid darkgrey;
            border-radius: 15px;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("contactForm").submit();
        }
    </script>

</head>

<body>
    <!-- Navbar -->
    <?php include 'includes/navbar.php'; ?>

    <form id="contactForm" name="contactForm" action="contactFormHandler.php" method="post">
        <legend>Contact Me</legend>
        <p>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name." required>
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address." required>
        </p>
        <p>
            <label for="reason">Reason for Contact:</label>
            <select id="reason" name="reason" required>
                <option value="">--Please choose an option--</option>
                <option value="support">Support</option>                
                <option value="feedback">Feedback</option>
                <option value="other">Other</option>
            </select>
        </p>
        <p>
            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" rows="4"></textarea>
        </p>

        <p>
            <button class="g-recaptcha"
                data-sitekey="6LfWifcjAAAAAIeCLWDlTwM2iIWh1sR60ls9qZdO"
                data-callback='onSubmit'
                data-action='submit'>Submit</button>
            <input type="reset" name="button2" id="button2" value="Reset" />
        </p>
    </form>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>
</body>

</html>