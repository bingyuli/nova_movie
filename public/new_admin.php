<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("admin_email","admin_name", "password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("admin_name" => 20);
  validate_max_lengths($fields_with_max_lengths);

  if(!validEmail($_POST['admin_email'])){		
	$errors[$required_fields[1]] = "Admin Email is not valid";		
  }
  
  if (empty($errors)) {
    // Perform Create
    $admin_email = $_POST["admin_email"];
    $admin_email = trim($admin_email);
    $admin_name = mysql_prep($_POST["admin_name"]);
    $password = $_POST["password"];
    
    $query  = "INSERT INTO administrator (";
    $query .= "  email, name, password";
    $query .= ") VALUES (";
    $query .= "  '{$admin_email}','{$admin_name}', '{$password}'";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Admin created.";
      redirect_to("manage_admins.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="manage_admins.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Create New Admin</h2>
    <form action="new_admin.php" method="post">	     
      <p>Admin name<br></br>
        <input type="text" name="admin_name" value="" />
      </p>
      <p>Email <br></br>
	      <input type="text" name="admin_email" value="" />
	  </p>
      <p>Password<br></br>
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Create Admin" class= "blue"/>
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>
