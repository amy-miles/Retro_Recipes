<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<?php echo "<!-- Current Page: $current_page -->"; ?>
<nav class="navbar navbar-expand-lg ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/inline_logo.png" alt="Logo" width="auto" height="30">
    </a>  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'userPage.php') ? 'active' : ''; ?>" href="userPage.php">My Recipes</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'contactForm.php') ? 'active' : ''; ?>" href="contactForm.php">Contact Me</a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($current_page == 'about.php') ? 'active' : ''; ?>" href="about.php">About This Academic Project</a>
        </li>
      </ul>
      <li class="d-flex nav-item">
        <a class="nav-link disabled" href="#">Register</a>
        <a class="nav-link <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Log Out</a>
        <a class="nav-link <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>" href="login.php">Log In</a>
      </li>
    </div>
  </div>
</nav>
