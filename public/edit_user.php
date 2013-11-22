<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $user = find_user_by_id($_GET["id"]);  
  if (!$user) {
    // user ID was missing or invalid or 
    // user couldn't be found in database
    redirect_to("manage_users.php");
  }
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
    $start_date =mysql_prep($_POST["start_date"]);
    $expr_date =mysql_prep($_POST["expr_date"]);

    $today = date("Y-m-d");
    if($expr_date < $today){
	$expired = 1;
	}else {
	$expired = 0;
	}

    $query  = "UPDATE user SET ";
    $query .= "name = '{$user_name}', ";
    $query .= "email = '{$user_email}', ";
    $query .= "password = '{$password}', ";
    $query .= "start_date = '{$start_date}', ";
    $query .= "expr_date = '{$expr_date}', ";
    $query .= "expired = {$expired} ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "User updated.";
      redirect_to("manage_users.php");
    } else {
      // Failure
      $_SESSION["message"] = "User update failed.";
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
    
    <h2>Edit User: <?php echo htmlentities($user["name"]); ?></h2>
    <form action="edit_user.php?id=<?php echo urlencode($user["id"]); ?>" method="post">

      <p>User Name<br></br>
        <input type="text" name="user_name" value="<?php echo htmlentities($user["name"]); ?>" />
      </p>

      <p>Email<br></br>
        <input type="text" name="user_email" value="<?php echo htmlentities($user["email"]); ?>" />
      </p>

	  <p>Password<br></br>
        <input type="password" name="password" value="" />
      </p>

      <p>Start Date<br></br>
        <input type="text" name="start_date" value="<?php echo htmlentities($user["start_date"]); ?>" />
      </p>

      <p>Expire Date<br></br>
        <input type="text" name="expr_date" value="<?php echo htmlentities($user["expr_date"]); ?>" />
      </p>

      <input type="submit" name="submit" value="Edit User" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>