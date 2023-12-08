<?php
$dbConn = new mysqli("localhost", "twa201", "twa201sU", "petrescue201");

 if($dbConn->connect_error) {
 die("Failed to connect to database (" . $dbConn->connect_error . ")"
  .$dbConn->connect_error);
 }
 ?>
 

