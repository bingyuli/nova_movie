<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>



<?php

if (isset($_POST['submit'])) {
	// Process the form
	// validations
	$required_fields = array("username","useremail", "password");
	validate_presences($required_fields);
	
	if (empty($errors)) {
		// Perform Create
		$user_name = mysql_prep($_POST["username"]);
		$user_email = mysql_prep($_POST["useremail"]);
		$user_password = $_POST["password"];
		
		
		$query  = "INSERT INTO user (";
		$query .= " name, email, password";
		$query .= ") VALUES (";
		$query .= "  '{$user_name}', '{$user_email}','{$user_password}'";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		
		
		if ($result) {
			// Success, find user from database
			$found_user =find_user_by_email($user_email);
			// Mark user as logged in
			
			$_SESSION["user_id"] = $found_user["id"];
			$_SESSION["user_name"] = $found_user["name"];
			$_SESSION["user_email"] = $found_user["email"];
			
			redirect_to("user_dashboard.php");
			
		} else {
			// Failure
			$_SESSION["message"] = "User account creation failed.";
			
		}
	}
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))

?>



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

    <h1><br></br>Ready to start your free month? </h1>
    <h2><br></br>Create your account:</h2>
    <form action="new_user.php" method="post">

		<p><br></br>Your First Name and Last Name <br></br>
		<input type="text" name="username" value="" />
		</p>

		<p>Email Address <br></br>
		<input type="text" name="useremail" value="" />
		</p>

		<p>Choose a password (4-20 characters)<br></br>
		<input type="password" name="password" value="" />
		</p>

		<p> 
		 <input type ="submit" name="submit" value="Register" class="blue" />
		</p>  

    </form>
    <br></br>
    <a href="index.php">Cancel</a>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>