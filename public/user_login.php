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
				$expr_date =mysql_prep($found_user["expr_date"]);
				$today = date("Y-m-d");    // 得到当前日期
				
				if($expr_date < $today){
					// set user expired
					$_SESSION["message"] = "Your status is already expired.";	
					$query  = "UPDATE user SET ";
					$query .= "expired = 1 ";
					$query .= "WHERE id ={$found_user["id"]}; ";
					$result = mysqli_query($connection, $query);
				}	
				
				// Mark user as logged in
				$_SESSION["user_id"] = $found_user["id"];
				$_SESSION["user_name"] = $found_user["name"];
				$_SESSION["user_email"] = $found_user["email"];
				$_SESSION["loggedin"] = true;
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
			<table>	<tr><td width ="360px">
			<p><br></br>Email <br></br>
			<input type="text" name="user_email" value="<?php echo htmlentities($user_email); ?>" />
			</p>

			<p>Password <br></br>
			<input type="password" name="password" value="" />
			</p>

			<p>
			<br></br><input type ="submit" name="submit" value="Continue" class="blue" >
			</p>
			
			<br></br>
			<a href="index.php">Cancel</a></td>
			<td>
			<img border="2" src="image/userbg.jpg" width="360" height="280"></td>	       
			</form>   
			</td>
			</tr></table>

		</div>
	  
    </div>
<?php include("../includes/layouts/footer.php"); ?>