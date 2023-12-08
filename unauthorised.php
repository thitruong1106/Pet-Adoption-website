<?php
   // ensure the page is not cached
   require_once("nocache.php");

   // get access to the session variables
   session_start();

   // check that the user is logged in
   if (!$_SESSION["who"]){
     header("location: logoff.php");
   }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Unauthorised Access</title>
  </head>

  <body>
    <h1>Unauthorised Access</h1>
    <p>You have tried to access a restricted page.<p>
    <p>Only <strong>
    <?php
       if (isset($_GET['user-type'])) {
         echo $_GET['user-type'];
       } else {
         echo 'Unknown';
       }
    ?>
    </strong>are allowed to access the <strong>

    <?php
       if (isset($_GET['page-title'])) {
         echo $_GET['page-title'];
       } else {
         echo 'Unknown';
       }
    ?>
    </strong> page.</p>
    <p><a href="staff.php">Return to Menu</a></p>
  </body>
</html>
