<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $admin = find_admin_by_id($_GET["id"]);  
  if (!$admin) {
    // admin ID was missing or invalid or 
    // admin couldn't be found in database
    redirect_to("manage_admins.php");
  }
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("admin_name","admin_email","password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("admin_name" =>20);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $admin["id"];
    $admin_name = mysql_prep($_POST["admin_name"]);
    $admin_email = mysql_prep($_POST["admin_email"]);
    $password = $_POST["password"];

    $query  = "UPDATE administrator SET ";
    $query .= "name = '{$admin_name}', ";
    $query .= "email = '{$admin_email}', ";
    $query .= "password = '{$password}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "Admin updated.";
      redirect_to("manage_admins.php");
    } else {
      // Failure
      $_SESSION["message"] = "Admin update failed." . "result: " . $result  ;
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
    
    <h2>Edit Admin: <?php echo htmlentities($admin["name"]); ?></h2>
    <form action="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>" method="post">

      <p>Admin Name: <br></br>
        <input type="text" name="admin_name" value="<?php echo htmlentities($admin["name"]); ?>" />
      </p>

      <p>Email:<br></br>
        <input type="text" name="admin_email" value="<?php echo htmlentities($admin["email"]); ?>" />
      </p>

	  <p>Password:<br></br>
        <input type="password" name="password" value="" />
      </p>
      <input type="submit" name="submit" value="Edit Admin" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>