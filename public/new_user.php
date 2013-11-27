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
	
	if(!validEmail($_POST['useremail'])&& has_presence($_POST['useremail']))
	{
		
		$errors[$required_fields[1]] = "User Email is not vaild";		
	} 
	
 	if(!validPassword($_POST['password'])&& has_presence($_POST['password']))
	{
		$errors[$required_fields[2]] = "Password is not safe!";		
	} 
	
	
	
	if (empty($errors)) {
		// Perform Create
		$user_name = mysql_prep($_POST["username"]);
		$user_email = mysql_prep($_POST["useremail"]);
		$user_password = $_POST["password"];
		$start_date =mysql_prep(date("Y-m-d"));
		$next_month = mktime(0,0,0,date("m")+1,date("d"),date("Y"));
		$expr_date = date("Y-m-d", $next_month);
		
		$query  = "INSERT INTO user (";
		$query .= " name, email, password,start_date,expr_date ";
		$query .= ") VALUES (";
		$query .= "  '{$user_name}', '{$user_email}','{$user_password}','{$start_date}', '{$expr_date}' ";
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

    
    <h2>Ready to start your free month?<br></br> 
	Create your account:</h2>
    <form action="new_user.php" method="post">

		<p><br></br>Your First Name and Last Name <br></br>
		<input type="text" name="username" value= "" placeholder="Fisrt Name Last Name" />
		</p>

		<p>Email Address <br></br>
		<input type="text" name="useremail" value="" placeholder="mymail@mail.com"/>
		</p>

		<p>Choose a password (4-20 characters) <br></br>
		<input type="password" name="password" value="" placeholder="eg. X8df!90EO"/>
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