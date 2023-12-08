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
    <!--<link rel="stylesheet" href="style.css">-->
    <title>Home page</title>
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
  </head>
  <body>
    <div class="topnav">
      <a class="active" href="index.php">Index</a>
      <a href="petlisting.php">Pet Listing</a>
      <div class="topnav-right"> <?php if ($isLoggedIn) { ?> <a>Welcome, <?php echo $name; ?> </a> <?php if ($_SESSION['is_admin'] == 1) { ?> <a href="manageadoption.php">Manage Adoption</a>
        <a href="managepetlisting.php">Manage Pet Listing</a> <?php } ?> <a href="logoff.php">Log off</a> <?php } else { ?> <a href="register.php">Register</a>
        <a href="login.php">Login</a> <?php } ?>
      </div>
    </div>
    <div class="container">
      <h1>Annie's Animal Adoptions</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse egestas finibus sem, consectetur sodales velit iaculis in. Etiam pellentesque blandit nulla quis fermentum. Maecenas et mollis justo, ac faucibus orci. Proin feugiat dolor eget elementum imperdiet. Vestibulum maximus elit sit amet enim condimentum sollicitudin. Nulla risus nisi, sollicitudin id euismod at, imperdiet eget quam. Integer eu elementum libero. Mauris hendrerit turpis sem, non commodo lorem commodo id. Praesent eleifend non justo finibus semper. Pellentesque eget convallis lacus. Sed at mi viverra mauris vehicula tempor non at magna. Phasellus euismod purus id venenatis convallis. Maecenas porta efficitur nisl, molestie convallis dui condimentum non. </p>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>