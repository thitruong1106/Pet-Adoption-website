<?php
// make sure page is not cached
require_once("nocache.php");
// access session variable
session_start(); 
   
   $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
   $isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Success</title>
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Index</a>
      <a href="petlisting.php">Pet Listing</a>
      <div class="topnav-right"> <?php if ($isLoggedIn) { ?> <a>Welcome, <?php echo $name; ?> </a> <?php if ($_SESSION['is_admin'] == 1) { ?> <a href="manageadoption.php">Manage Adoption</a>
        <a href="managepetlisting.php">Manage Pet Listing</a> <?php } ?> <a href="logoff.php">Log off</a> <?php } else { ?> <a href="register.php">Register</a>
        <a href="login.php">Login</a> <?php } ?>
      </div>
    </div>
    <div class="container">
      <p>Thank you for submitting your application. Your application will be reviewed. We will contact you with updates soon.</p>
      <a herf="index.php">go back to home page</a>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>