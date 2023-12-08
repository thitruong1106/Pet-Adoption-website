<?php
// make sure page is not cached
require_once("nocache.php");
// access session variable
session_start(); 
     if (!$_SESSION["who"]){
     header("location: logoff.php");
   }
   $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
   $isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];
   
   if ($_SESSION["is_admin"] != 1) {
    header("location: index.php");
    exit(); // Stop executing the rest of the code
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Menu</title>
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
    <h1>Page Menu</h1>
    <ul> <?php if($_SESSION['is_admin'] == 1) {?> <li>
        <a href="managepetlisting.php">Manage Pets</a>
      </li>
      <li>
        <a href="manageadoption.php">Manage Adoption</a>
      </li> <?php } ?>
    </ul>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>