<?php
   // ensure page is not cached
   require_once("nocache.php");

   $errorMessage = '';
 
 session_start(); 
  $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
   $isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];
   // check that the form has been submitted
   if(isset($_POST['submit'])) {

     // check that username and password were entered
     if(empty($_POST['email']) || empty($_POST['pword'])) {
        $errorMessage = "Both username and password are required";
     } else {
        // connect to the database
        require_once('dbconn.php');

        // parse username and password for special characters
        $email= $dbConn->escape_string($_POST['email']);
        $password = $dbConn->escape_string($_POST['pword']);

        // hash the password so it can be compared with the db value
        $hashedPassword = hash('sha256', $password);

        // query the db
        $sql = "select user_id, is_admin,first_name from users where email= '$email' and password = '$hashedPassword'";
        $rs = $dbConn->query($sql);

        // check number of rows in record set. What does this mean in this context?
        if($rs->num_rows) {
            // start a new session for the user
            session_start();

            // Store the user details in session variables
            $user = $rs->fetch_assoc();
            $_SESSION['who'] = $user['user_id'];
            $_SESSION['is_admin'] = $user['is_admin'];
             $_SESSION['first_name'] = $user['first_name'];
            // Redirect the user to the secure page
            header('Location: staff.php');

        } else {
            $errorMessage = "Invalid Username or Password";
        }
     }
   }
?>
<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">

</head>
<body>
    <div class="topnav">
        <a href="index.php">Index</a>
        <a href="petlisting.php">Pet Listing</a>
        <div class="topnav-right">
            <?php if ($isLoggedIn) { ?>
                <a>Welcome, <?php echo $name; ?> </a>
                <?php if ($_SESSION['is_admin'] == 1) { ?>
                    <a href="manageadoption.php">Manage Adoption</a>
                    <a href="managepetlisting.php">Manage Pet Listing</a>
                <?php } ?>
                <a href="logoff.php">Log off</a>
            <?php } else { ?>
                <a href="register.php">Register</a>
                <a href="login.php">Login</a>
            <?php } ?>
        </div>
    </div>
    <div class="container">

  <h1>Annies Animal Adoptions</h1>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
       <p style="color:red;"><?php echo $errorMessage;?></p>
       <div class="input-box">
         <label for="email">email:</label>
         <input type="text" name="email" maxlength="50" id="email">
       </div>
       <div class="input-box">
         <label for="pword">Password:</label>
         <input type="password" name="pword" maxlength="20" id="pword">
       </div>
       <div class="input-box">
         <input type="submit" value="Login" name="submit">
       </div>
    </form>
</div>
</div>
</body>

</html>
