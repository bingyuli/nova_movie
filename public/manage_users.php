<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $user_set = find_all_users();
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php 
  $current_id = htmlentities($_SESSION["admin_id"]); ?>

<div class="hlinks">
   <a href="admin_dashboard.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
	  &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    <h2>Manage Users</h2>

    <table>
      <tr>
        <th style="text-align: left; width: 130px;">User Name</th>
        <th style="text-align: left; width: 140px;">Email</th>
        <th style="text-align: left; width: 140px;">Start_date</th>
        <th style="text-align: left; width: 140px;">Expire_date</th>
        <th style="text-align: left; width: 90px;">Expired</th>
      </tr>
    <?php while($user = mysqli_fetch_assoc($user_set)) { ?>
      <tr>
        <td><?php echo htmlentities($user["name"]); ?></td>
        <td><?php echo htmlentities($user["email"]); ?></td>
		<td><?php echo htmlentities($user["start_date"]); ?></td>
		<td><?php echo htmlentities($user["expr_date"]); ?></td>
		<td><?php if ($user["expired"]!=0){
			 echo "Yes";
	     	} else{
		     echo "No";
        	}?>
		</td>
			
        <td><a href="edit_user.php?id=<?php echo urlencode($user["id"]); ?>">Edit</a></td>
        <td><a href="delete_user.php?id=<?php echo urlencode($user["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
      </tr>
    <?php } ?>
    </table>
    <br></br>
    <a href="add_new_user.php">Add new user</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>