<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>

<?php
  $user = find_user_by_id($_GET["id"]);  
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("user_name","user_email","password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("user_name" =>20);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $user["id"];
    $user_name = mysql_prep($_POST["user_name"]);
    $user_email = mysql_prep($_POST["user_email"]);
    $password = $_POST["password"];
    

    $query  = "UPDATE user SET ";
    $query .= "name = '{$user_name}', ";
    $query .= "email = '{$user_email}', ";
    $query .= "password = '{$password}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result 
		//&& mysqli_affected_rows($connection) == 1
		) {
      // Success
      $_SESSION["message"] = "User updated.";
      redirect_to("user_dashboard.php");
    } else {
      // Failure
      $_SESSION["message"] = "User update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>


<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="user_dashboard.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit User: <?php echo htmlentities($user["name"]); ?></h2>
    <form action="user_edit_profile.php?id=<?php echo urlencode($_SESSION["user_id"]); ?>" method="post">

      <p>User Name<br></br>
        <input type="text" name="user_name" value="<?php echo htmlentities($user["name"]); ?>" />
      </p>

      <p>Email<br></br>
        <input type="text" name="user_email" value="<?php echo htmlentities($user["email"]); ?>" />
      </p>

	  <p>Password<br></br>
        <input type="password" name="password" value="" />
      </p>

      <input type="submit" name="submit" value="Edit User" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>