   
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
   
  require_once("dbconn.php");
  
  
  if (!$dbConn) { die("Connection failed: " . mysqli_connect_error()); }
   // get access to the session variables
   session_start();

   // check that the user is logged in
   if (!$_SESSION["who"]){
     header("location: logoff.php");
   }
   


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
  $statusApp= $dbConn->escape_string($_GET["appID"]);
  $sql = "select * from adoptions ";
  $sql = $sql  . " where application_id = '$statusApp'";
  $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);
  
  if (isset($_POST["verdict"])) {
  $verdict = $dbConn->escape_string($_POST["verdict"]);
  
  if($verdict == "Approved") {
 $currentDate = date("Y-m-d H:i:s");
  $sql = "UPDATE adoptions SET application_status = '$verdict', adoption_date = '$currentDate' WHERE application_id = '$statusApp'";
     $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);

   } else {
     $sql = "UPDATE adoptions SET application_status = '$verdict' WHERE application_id = '$statusApp'";
    $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);

   }
  
//redirect back to manage.php after updteing status
  header("Location: manageadoption.php");
  exit(); 
  }
  
 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>View adoption</title>
<link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
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
    <div class="container">
  <h2>View Adoption<?php echo htmlspecialchars($statusApp)?></h2>
  <table>
    <tr>
      <td>Application ID</td>
      <td>Pet ID</td>
      <td>user ID</td>
      <td>aplpication date</td>
      <td>aplpication status</td>
      <td>aplpication notes</td>
      <td>aplpication date</td>
      </tr>
    <?php while ($row = $results ->fetch_assoc()) : ?>
      <tr>
        <td><?php echo ($row["application_id"])?></td>
        <td><?php echo ($row["pet_id"])?></td>
        <td><?php echo ($row["user_id"])?></td>
        <td><?php echo ($row["application_date"])?></td>
        <td><?php echo ($row["application_notes"])?></td>
        <td><?php echo ($row["adoption_date"])?></td>
        <form action="viewadoption.php?appID=<?php echo $statusApp?>" method="POST">
          <select name="verdict">
            <option value="Pending">Pending</option> 
            <option value="Approved">Approved</option> 
            <option value="Rejected">Rejected</option> 
          </select>
        <input type="submit" value="submit">
        </form>
        
      </tr>
    <?php endwhile;
      $dbConn->close();
    ?>
  </table>
  </div>
  <footer>
<p>18682713 Thi Kim Truong</p>
</footer>
</body>
</html>
