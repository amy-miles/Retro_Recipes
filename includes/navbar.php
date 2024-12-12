<?php
// Get the current page name to set active link
$current_page = basename($_SERVER['PHP_SELF']);
?>
<?php echo "<!-- Current Page: $current_page -->"; ?>
<nav class="navbar navbar-expand-lg navbar-light ">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">
      <img src="assets/inline_logo.png" alt="Logo" width="auto" height="30">
    </a>
    <!-- Add the toggle button for collapsing the navbar -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
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
        <a class="nav-link" <?php echo ($current_page == 'register.php') ? 'active' : ''; ?>" href="register.php">Register</a>
        <a class="nav-link <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>" href="logout.php">Log Out</a>
        <a class="nav-link <?php echo ($current_page == 'login.php') ? 'active' : ''; ?>" href="login.php">Log In</a>
      </li>
    </div>
  </div>
</nav>
