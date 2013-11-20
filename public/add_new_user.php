<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("user_name", "user_email","password");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("user_name" => 20);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create
    $user_name = mysql_prep($_POST["user_name"]);
    $user_email =mysql_prep($_POST["user_email"]);
    $password = $_POST["password"];
    $start_date =mysql_prep($_POST["start_date"]);
    $expr_date =mysql_prep($_POST["expr_date"]);
    
    $query  = "INSERT INTO user (";
    $query .= " name, email, password,start_date,expr_date ";
    $query .= ") VALUES (";
    $query .= "  '{$user_name}', '{$user_email}', '{$password}', '{$start_date}', '{$expr_date}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "User added.";
      redirect_to("manage_users.php");
    } else {
      // Failure
      $_SESSION["message"] = "User addition failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="manage_users.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2><br></br>Add New User</h2>
    <form action="add_new_user.php" method="post">	     
      <p>User name<br></br>
        <input type="text" name="user_name" value="" />
      </p>
      <p>Email <br></br>
	      <input type="text" name="user_email" value="" />
	  </p>	
	  <p>Password<br></br>
        <input type="password" name="password" value="" />
      </p>	
	  <p>Start Date <br></br>
	      <input type="text" name="start_date" value="<?php echo date("Y-m-d"); ?>" />
	  </p>
	  <p>Expire Date <br></br>
	      <input type="text" name="expr_date" value="<?php 
		$next_month = mktime(0,0,0,date("m")+1,date("d"),date("Y"));
		echo date("Y-m-d", $next_month); ?> 
		" />
	  </p>
     
      <input type="submit" name="submit" value="Add User" class= "blue"/>
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>