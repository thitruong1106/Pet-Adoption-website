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
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
    <title>Pet Listing</title>
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
   require_once("dbconn.php");
   $name = $dbConn->escape_string($_POST['speciesName']);
   $gender= $dbConn->escape_string($_POST['gender']);
   $store = array(); 
   $sql = "select * from pets where status = 'Available'";
   if(!empty($name)){
    $sql .= "AND species = '$name'";
   }
   if(!empty($gender)){
    $sql .= "AND gender = '$gender'"; 
   }
   
   
   $rs = $dbConn->query($sql)
     or die ('Problem with query' . $dbConn->error);
?> <div class="container"> <?php
   // testing whether such records exist
   if ($rs->num_rows) { ?> <p>Pets <strong> <?php echo "$name"; ?> </strong> details: </p>
      <table>
        <tr>
          <td>Phone Number</td>
          <td>Email</td>
          <td>Suburb</td>
        </tr> <?php while ($row = $rs->fetch_assoc()) { ?> <tr>
          <td>
            <a href="petdetail.php?pName=
                  <?php echo $row["name"] ?>"> <?php echo $row["name"]?> </a>
            </p>
          <td>
            <img src="
                  <?php echo $row['image_path']; ?>" class="pet-image">
          </td>
          <td> <?php echo $row["suburb"]?> </td>
          <td> <?php echo $row["state"]?> </td>
          <td> <?php echo $row["species"]?> </td>
        </tr> <?php } ?>
      </table> <?php }
   else {?> <p>No pets with species <?php echo $name ?> in the pets database. </p> <?php } ?>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>