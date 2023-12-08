<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <!--<link rel="stylesheet" href="style.css">-->
  <title>Annies Animal Adoptions</title><!-- add '' to annie name after -->
  <style>
    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
    }
    li {
      float: left;
    }

    li a {
      display: block;
      color: white;
      text-align: center;
      text-decoration: none;
      padding: 14px 16px;
    }
    h1 {
      text-align: center;
    }
  </style>
</head>
<body>
<ul>
    <li><a href="index.html">Index</a></li>
    <li><a href="petlisting.php">Pet Listing</a></li>
    <li><a href="index.html">Register</a></li>
    <li><a href="index.html">Login</a></li> <!-- I WANT THIS ON THE LEFT SAME WITH REG -->
  </ul>
<?php 
  require_once("dbconn.php");
  $sql = "SELECT * 
    FROM pets
    WHERE status = 'Available'";
    
  $results = $dbConn->query($sql) or die('Problem with query: ' . $dbConn->error);
    ?>
    
  <h1>pet listing page</h1>
  <h2>Avaiable Pets</h2>
  <table>
  <tr>
    <th>Name</th>
    <th>suburb</th>
    <th>state</th>
  </tr>
  <?php
  if (mysqli_num_rows($results) > 0) {
    while ($row = $results->fetch_assoc()) {
    ?>
    <tr>
    <td><?php echo $row["name"];?></td>
    <td><?php echo $row["suburb"];?></td>
    <td><?php echo $row["state"];?></td>
    <td><?php echo $row["image_path"];?></td>
    </tr>
    <?php
    }
    }else {
    echo "There are no results";
    }
    $dbConn->close();
    ?>
  </table>
  

</body>
</html>