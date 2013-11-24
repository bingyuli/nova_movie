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
  $interested_set = find_interested_by_userid($_GET["id"]);  
  if (!$interested_set) {
    // interested was missing or invalid or 
    // interested couldn't be found in database
    redirect_to("manage_users.php");
  }
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="edit_user.php?id=<?php echo urlencode($user["id"]); ?>"><span class="text">Back</span></a>
   <a href="admin_dashboard.php"><span class="text">Admin Dashboard</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    
    <h2>User Name: <?php echo htmlentities($user["name"]); ?></h2>

	<table>
    <tr>
	    <th style="text-align: left; ">Interested Movie List</th>
    </tr>

	
	<?php while($interested = mysqli_fetch_assoc($interested_set)) { ?>
	<tr><td>
	     <?php echo htmlentities($interested["name"]); ?> 
	
	</td></tr>
	<?php } ?>
	
	</table>

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>