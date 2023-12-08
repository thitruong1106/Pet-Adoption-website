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
    <title>Register</title>
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
    <script src="/twa/twa201/project/javascript/script.js" defer></script>
  </head>
  <body>
    <div class="topnav">
      <a href="index.php">Index</a>
      <a href="petlisting.php">Pet Listing</a>
      <div class="topnav-right"> <?php if ($isLoggedIn) { ?> <a>Welcome, <?php echo $name; ?> </a> <?php if ($_SESSION['is_admin'] == 1) { ?> <a href="manageadoption.php">Manage Adoption</a>
        <a href="managepetlisting.php">Manage Pet Listing</a> <?php } ?> <a href="logoff.php">Log off</a> <?php } else { ?> <a href="register.php">Register</a>
        <a href="login.php">Login</a> <?php } ?>
      </div>
    </div> <?php 
  include("dbConn.php");

     if(isset($_POST['submit']))
     {
         $firstName=$dbConn->real_escape_string($_POST['fname']);
         $lastName=$dbConn->real_escape_string($_POST['lname']); 
         $emailadd=$dbConn->real_escape_string($_POST['emailadd']); 
         $mobile=$dbConn->real_escape_string($_POST['mobileno']); 
         $password = hash('sha256', $_POST['password']);

         $res=mysqli_query($mysqli,"INSERT into users ('','$firstName','$lastName','$emailadd', '$mobile', '$password')");
         if($res)
         {
         echo "sucess";
         }
         else {
         echo "not sucess";
         }
     }
  ?> <div class="container">
      <div class="form">
        <form action="process.php" method="POST" onsubmit="return validateForm(this);">
          <div class="form-element">
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname">
            <span class="error-messages" id="fname-error">First Name is required</span>
          </div>
          <div class="form-element">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname">
            <span class="error-messages" id="lname-error">Last Name is required</span>
          </div>
          <div class="form-element">
            <label for="emailadd">Email</label>
            <input type="text" name="emailadd" id="emailadd">
            <span class="error-messages" id="emailadd-error">Email is required</span>
          </div>
          <div class="form-element">
            <label for="mobileno">Mobile</label>
            <input type="text" name="mobileno" id="mobileno">
            <span class="error-messages" id="mobileno-error">Mobile is required</span>
          </div>
          <div class="form-element">
            <label for="password">Password</label>
            <input type="text" name="password" id="password">
            <span class="error-messages" id="password-error">password is required</span>
          </div>
          <div class="form-element">
            <input type="submit" name="submit-button" value="submit">
          </div>
        </form>
      </div>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>