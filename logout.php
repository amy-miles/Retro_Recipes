

    <?php
    session_start();
    //destroy the session
    session_unset();
    session_destroy();


    //disconnect from the database
    $conn = null;
    $stmt = null;

    //redirect to home page or login
    header("Location:index.php");



    ?>