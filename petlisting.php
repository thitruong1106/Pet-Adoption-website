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
    <title>Pet Listing</title>
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
    </div> <?php 
 
    require_once("dbconn.php");
    $sql = "SELECT DISTINCT name, suburb, state, image_path 
        FROM pets
        WHERE status = 'Available'";
        
    $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);
        ?> <div class="container">
      <h2>Avaiable Pets</h2>
      <form id="searchSpecies" method="post" action="filterPet.php">
        <p>
          <label for="speciesName"> Spieces Surname Search:</label>
          <input type="text" name="speciesName" id="speciesName" maxlength="30">
        </p>
        <p>
          <label for="gender">Gender</label>
          <select name="gender" id="gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Unknown">Unknown</option>
          </select>
        </p>
        <p>
          <input type="submit">
        </p>
      </form>
      <table>
        <tr>
          <th>Name</th>
          <th>suburb</th>
          <th>state</th>
          <th>photo</th>
        </tr> <?php
    if (mysqli_num_rows($results) > 0) {
        while ($row = $results->fetch_assoc()) {
        ?> <tr>
          <td>
            <a href="petdetail.php?pName=<?php echo $row["name"] ?>"> <?php echo $row["name"]?> </a>
            </p>
          <td> <?php echo $row["suburb"];?> </td>
          <td> <?php echo $row["state"];?> </td>
          <td>
            <img src="
                                            <?php echo $row['image_path']; ?>" class="pet-image">
          </td>
        </tr> <?php
        }
        }else {
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