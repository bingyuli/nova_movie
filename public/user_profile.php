<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php
  $user = find_user_by_id($_GET["id"]);  
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
    
    <h2>Your Profile: <?php echo htmlentities($user["name"]); ?></h2>
    

		<p>User Name<br></br>
		<?php echo htmlentities($user["name"]); ?>
		</p>

		<p>Email<br></br>
		<?php echo htmlentities($user["email"]); ?>
		</p>

		<p>Start Date<br></br>
		<?php echo htmlentities($user["start_date"]); ?>
		</p>
		<p>Expried Date<br></br>
		<?php echo htmlentities($user["expr_date"]); ?>
		</p>

		<a href="user_edit_profile.php">Edit Your Profile</a>
   
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>