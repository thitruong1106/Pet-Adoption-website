<?php
   // ensure that the page is not cached
   require_once("nocache.php");
   require_once("dbConn.php");
   
      $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';

  if (!$dbConn) { die("Connection failed: " . mysqli_connect_error()); }
   // get access to the session variables
   session_start();

   // check that the user is logged in
   if (!$_SESSION["who"]){
     header("location: logoff.php");
   }
   

   $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
   $isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];


   // check the access-level of the logged in staff member
   if ($_SESSION["is_admin"] != 1){

     // record the page that was accessed; record the user type needed
     $getVariables = array(
        'page-title' => 'Update Accounts',
        'user-type' => 'Staff Administrator'
     );

     // Add data to query string
     header("location: unauthorised.php?".http_build_query($getVariables));
   }
   

   
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
    <title>Manage Adoption</title>
  </head>

  <body>
        <div class="topnav">
        <a href="index.php">Index</a>
        <a href="petlisting.php">Pet Listing</a>
        <div class="topnav-right">
            <?php if ($isLoggedIn) { ?>
                <a>Welcome, <?php echo htmlspecialchars($name); ?> </a>
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
    
    
    <?php 
      require_once("dbconn.php");
      $sql = "SELECT * FROM adoptions";
      $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);
    ?>
<div class="container">
    <h1>Manage Adoption Applications</h1>
    
    <table>
      <tr>
        <th>Application ID</th> 
        <th>Pet ID</th> 
        <th>User ID</th> 
        <th>Application Status</th> 
        <th>Application Notes</th> 
        <th>Adoption Date</th>
      </tr>
      
      <?php
      if (mysqli_num_rows($results) > 0) {
        while ($row = $results->fetch_assoc()) {
      ?>
      <tr>
        <td><a href="viewadoption.php?appID=<?php echo $row["application_id"] ?>"><?php echo $row["application_id"]?></a></td>
        <td><?php echo htmlspecialchars($row["pet_id"]);?></td>
        <td><?php echo htmlspecialchars($row["user_id"]);?></td>
        <td><?php echo htmlspecialchars($row["application_status"]);?></td>
        <td><?php echo htmlspecialchars($row["application_notes"]);?></td>
        <td><?php echo $row["adoption_date"] ? htmlspecialchars($row["adoption_date"]) : "";?></td>
      </tr>
      <?php
        }
      } else {
        echo "There are no results";
      }
      $dbConn->close();
      ?>
    </table>
    </div>
    <footer>
<p>18682713 Thi Kim Truong</p>
</footer>
  </body>
</html>