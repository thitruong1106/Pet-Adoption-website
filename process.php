//https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php
<?php
// Include the database connection file
require_once('dbconn.php');
// Retrieve the form data
$firstname = $_POST['fname'];
$lastname = $_POST['lname'];
$email = $_POST['emailadd'];
$mobile = $_POST['mobileno'];
$password = hash('sha256', $_POST['password']);

// guard against SQL injection and XSS attacks
$firstname = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
$lastname = htmlspecialchars($lastname, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$mobile = htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8');

// Prepare the SQL statement with placeholders to prevent SQL injection
$stmt = $dbConn->prepare("INSERT INTO users (first_name , last_name, email, mobile, password) VALUES (?, ?, ?, ?, ?)");

// Bind the form data to the prepared statement
$stmt->bind_param("sssss", $firstname, $lastname, $email, $mobile, $password);

// Execute the statement
if ($stmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Registration failed: " . $stmt->error;
}

// Close the statement and database connection
$stmt->close();
$dbConn->close();
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
<h2> Welcome <?php echo $name; ?> 
<p> Your registration is completed</p> 
    
<footer>
<p>18682713 Thi Kim Truong</p>
</footer>
  </body>
</html>