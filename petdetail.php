<?php
// make sure page is not cached
require_once("nocache.php");
// access session variable
session_start();

$name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
$userID = isset($_SESSION['who']) ? $_SESSION['who'] : '';
$isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];

require_once("dbconn.php");

$petName = isset($_GET["pName"]) ? $dbConn->escape_string($_GET["pName"]) : '';
// Retrieve the pet_id based on the pet name
$sql = "SELECT * FROM pets WHERE name = '$petName'";
$results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);

$petId = 0;
$petSql = "SELECT pet_id FROM pets WHERE name = '$petName'";
$petResult = $dbConn->query($petSql) or die('Problem with query: ' . $dbConn->error);
if ($petResult->num_rows > 0) {
    $petId = $petResult->fetch_assoc()['pet_id'];
} else {
    die('Invalid pet name');
}

// Check if the adoption application form is submitted
if (isset($_POST['submit'])) {
    $fullName = isset($_POST['full_name']) ? $dbConn->escape_string($_POST['full_name']) : '';
    $email = isset($_POST['emailadd']) ? $dbConn->escape_string($_POST['emailadd']) : '';
    $mobileNo = isset($_POST['mobileNo']) ? $dbConn->escape_string($_POST['mobileNo']) : '';
    $statement = isset($_POST['application-notes']) ? $dbConn->escape_string($_POST['application-notes']) : '';

    $insertSql = "INSERT INTO adoptions (pet_id, user_id, application_notes, application_status)
                  VALUES ($petId, $userID, '$statement', 'pending')";
    $insertResult = $dbConn->query($insertSql) or die('Problem with query: ' . $dbConn->error);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Pet Detail</title>
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
      <h2>Pet Details <?php echo $petName?> </h2>
      <table>
        <tr>
          <td>Name</td>
          <td>Species</td>
          <td>Breed</td>
          <td>Age</td>
          <td>Gender</td>
          <td>Description</td>
          <td>Image</td>
          <td>Status</td>
          <td>Suburb</td>
          <td>State</td>
          <td>Fee</td>
        </tr> <?php while ($row = $results->fetch_assoc()) : ?> <tr>
          <td> <?php echo $row["name"]?> </td>
          <td> <?php echo $row["species"]?> </td>
          <td> <?php echo $row["breed"]?> </td>
          <td> <?php echo $row["age"]?> </td>
          <td> <?php echo $row["gender"]?> </td>
          <td> <?php echo $row["description"]?> </td>
          <td>
            <img src="
                  <?php echo $row['image_path']; ?>" class="pet-image">
          </td>
          <td> <?php echo $row["status"]?> </td>
          <td> <?php echo $row["suburb"]?> </td>
          <td> <?php echo $row["state"]?> </td>
          <td> <?php echo $row["fee"]?> </td>
        </tr> <?php endwhile;
    $dbConn->close();
    ?>
      </table> <?php if ($isLoggedIn) : ?> <h3>Adoption Application</h3>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="fullName">Full name:</label>
        <input type="text" name="full_name">
        <br>
        <label for="emailadd">Contact Details:</label>
        <input type="text" name="emailadd">
        <br>
        <label for="mobileNo">Mobile:</label>
        <input type="text" name="mobileNo">
        <br>
        <label for="application-notes">Statement:</label>
        <textarea name="application-notes" rows="3"></textarea>
        <br>
        <input type="submit" name="submit" value="Submit Application">
      </form> <?php else : ?> <p>Please <a href="login.php">login</a> or <a href="register.php">register</a> to submit an adoption application. </p> <?php endif; ?>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>