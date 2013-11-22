<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
	$user_email = "";
	
	if (isset($_POST['submit'])) {
		// Process the form
		
		// validations
		$required_fields = array("user_email", "password");
		validate_presences($required_fields);
		
		if (empty($errors)) {
			// Attempt Login
			
			$user_email = $_POST["user_email"];
			$password = $_POST["password"];
			
			$found_user = user_attempt_login($user_email, $password);
			
			if ($found_user) {
				// Success
				// Mark user as logged in
				$_SESSION["user_id"] = $found_user["id"];
				$_SESSION["user_name"] = $found_user["name"];
				$_SESSION["user_email"] = $found_user["email"];
				redirect_to("user_dashboard.php");
			} else {
				// Failure
				$_SESSION["message"] = "User Email/password not found.";
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

      </div>
      <div id="page">
			<?php echo message(); ?>
			<?php echo form_errors($errors); ?>

			<h2><br></br>Member Sign In </h2>
			<form action="user_login.php" method= "post">
			<p><br></br>Email <br></br>
			<input type="text" name="user_email" value="<?php echo htmlentities($user_email); ?>" />
			</p>

			<p>Password <br></br>
			<input type="password" name="password" value="" />
			</p>

			<p>
			<input type ="submit" name="submit" value="Continue" class="blue" >
			</p>
				       
			</form>   

			<br></br>
			<a href="index.php">Cancel</a>
		</div>
	  
    </div>
<?php include("../includes/layouts/footer.php"); ?>