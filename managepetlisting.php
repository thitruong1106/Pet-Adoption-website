<?php
   // ensure that the page is not cached
   require_once("nocache.php");
   require_once("dbConn.php");
   if (!$dbConn) { die("Connection failed: " . mysqli_connect_error()); }
   // get access to the session variables
   session_start();

   // check that the user is logged in
   if (!$_SESSION["who"]){
     header("location: logoff.php");
   }
   $name = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : '';
   $isLoggedIn = isset($_SESSION['who']) && $_SESSION['who'];
   // check the access-level of the logged-in staff member
   if ($_SESSION["is_admin"] != 1){

     // record the page that was accessed; record the user type needed
     $getVariables = array(
        'user-type' => 'Staff Administrator'
     );

     // Add data to query string
     header("location: unauthorised.php?".http_build_query($getVariables));
     exit;
   }

   $error = array();

   $validations = array(
      "name" => "Name is required.",
      "species" => "Species is required.",
      "breed" => "Breed is required.",
      "age" => "Age is required.",
      "gender" => "Gender is required.",
      "description" => "Description is required.",
      "image_path" => "Image path is required.",
      "status" => "Status is required.",
      "suburb" => "Suburb is required.",
      "state" => "State is required.",
      "fee" => "Fee is required."
   );

   // Perform server-side validation and prevent XSS attacks
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_new"])) {
      foreach ($validations as $field => $message) {
         if (empty($_POST[$field])) {
            $error[$field] = $message;
         }
      }

      // Sanitize user input to prevent XSS attacks
      $name = htmlspecialchars($_POST["name"]);
      $species = htmlspecialchars($_POST["species"]);
      $breed = htmlspecialchars($_POST["breed"]);
      $age = intval($_POST["age"]);
      $gender = htmlspecialchars($_POST["gender"]);
      $description = htmlspecialchars($_POST["description"]);
      $image_path = htmlspecialchars($_POST["image_path"]);
      $status = htmlspecialchars($_POST["status"]);
      $suburb = htmlspecialchars($_POST["suburb"]);
      $state = htmlspecialchars($_POST["state"]);
      $fee = floatval($_POST["fee"]);

      if (empty($error)) {
         // All fields are valid, proceed with inserting the pet
         $query = "INSERT INTO pets (name, species, breed, age, gender, description, image_path, status, suburb, state, fee) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

         $stmt = mysqli_prepare($dbConn, $query);
         mysqli_stmt_bind_param($stmt, "sssissssssd", $name, $species, $breed, $age, $gender, $description, $image_path, $status, $suburb, $state, $fee);

         if (mysqli_stmt_execute($stmt)) {
            // Insertion successful
            echo "New pet added successfully!";
         } else {
            // Insertion failed
            echo "Failed to add new pet. Error: " . mysqli_error($dbConn);
         }

         mysqli_stmt_close($stmt);
      }
   }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="/twa/twa201/project/css/project.css" type="text/css">
    <title>Add pet</title>
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
      <h1>Add Pets</h1>
      <form method="POST" action="
              <?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
          <div class="column">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Name"> <?php if (!empty($error['name'])) { echo "
                    <p class='error'>".$error['name']."</p>"; } ?> <label for="species">Species</label>
            <input type="text" name="species" placeholder="Species"> <?php if (!empty($error['species'])) { echo "
                      <p class='error'>".$error['species']."</p>"; } ?> <label for="breed">Breed</label>
            <input type="text" name="breed" placeholder="Breed"> <?php if (!empty($error['breed'])) { echo "
                        <p class='error'>".$error['breed']."</p>"; } ?> <label for="age">Age</label>
            <input type="number" name="age" placeholder="Age"> <?php if (!empty($error['age'])) { echo "
                          <p class='error'>".$error['age']."</p>"; } ?> <label for="gender">Gender</label>
            <select name="gender">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Unknown">Unknown</option>
            </select> <?php if (!empty($error['gender'])) { echo "
                          <p class='error'>".$error['gender']."</p>"; } ?> <label for="description">Description</label>
            <input type="text" name="description" placeholder="Description"> <?php if (!empty($error['description'])) { echo "
                            <p class='error'>".$error['description']."</p>"; } ?>
          </div>
          <div class="column">
            <label for="image_path">Image Path</label>
            <input type="text" name="image_path" placeholder="Image Path"> <?php if (!empty($error['image_path'])) { echo "
                              <p class='error'>".$error['image_path']."</p>"; } ?> <label for="status">Status</label>
            <select name="status">
              <option value="Adopted">Adopted</option>
              <option value="Available">Available</option>
              <option value="Adoption Pending">Pending</option>
            </select> <?php if (!empty($error['status'])) { echo "
                              <p class='error'>".$error['status']."</p>"; } ?> <label for="suburb">Suburb</label>
            <input type="text" name="suburb" placeholder="Suburb"> <?php if (!empty($error['suburb'])) { echo "
                                <p class='error'>".$error['suburb']."</p>"; } ?> <label for="state">State</label>
            <input type="text" name="state" placeholder="State"> <?php if (!empty($error['state'])) { echo "
                                  <p class='error'>".$error['state']."</p>"; } ?> <label for="fee">Fee</label>
            <input type="number" name="fee" placeholder="Fee"> <?php if (!empty($error['fee'])) { echo "
                                    <p class='error'>".$error['fee']."</p>"; } ?>
          </div>
        </div>
        <div class="row">
          <input type="submit" name="add_new" value="Add New">
        </div>
      </form>
    </div>
    <footer>
      <p>18682713 Thi Kim Truong</p>
    </footer>
  </body>
</html>