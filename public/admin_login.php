<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$admin_email = "";

if (isset($_POST['submit'])) {

  // Process the form
  
  // validations
  $required_fields = array("admin_email", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$admin_email = $_POST["admin_email"];
        $admin_email = trim($admin_email);
		
		$password = $_POST["password"];
		
		$found_admin = admin_attempt_login($admin_email, $password);

    if ($found_admin) { // Success
			// Mark user as logged in
			$_SESSION["admin_id"] = $found_admin["id"];
			$_SESSION["admin_name"] = $found_admin["name"];
			$_SESSION["admin_email"] = $found_admin["email"];
			
		 redirect_to("admin_dashboard.php");	
	} else {
			// Failure
			$_SESSION["message"] = "User Email/password not found.";
			}
			
  	}
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>


<div class="hlinks">
   <a href="index.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
       &nbsp;
  </div>
     
<div id="page">
	<?php echo message(); ?>
    <?php echo form_errors($errors); ?>

  <h2><br></br>Administrator Sign In </h2>
  <form action="admin_login.php" method= "post">
	
	<p><br></br>Email <br></br>
      <input type="text" name="admin_email" value=" <?php echo htmlentities($admin_email); ?>" />
    </p>

    <p>Password <br></br>
       <input type="password" name="password" value="" />
    </p>
		
	<input type ="submit" name="submit" value="Continue" class="blue" />  	     
  </form>   

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>