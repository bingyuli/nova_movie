<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $actor_set = find_all_actors();
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
    <h2>Manage Actors</h2>

    <table>
      <tr>
        <th style="text-align: left; width: 200px;">Actor Name</th>
        <th colspan="2" style="text-align: left;width: 180px;">Gender</th>
      </tr>
    <?php while($actor = mysqli_fetch_assoc($actor_set)) { ?>
      <tr>
        <td><?php echo htmlentities($actor["name"]); ?></td>
        <td><?php echo htmlentities($actor["gender"]); ?></td>
	
        <td><a href="edit_actor.php?id=<?php echo urlencode($actor["id"]); ?>">Edit</a></td>
        <td><a href="delete_actor.php?id=<?php echo urlencode($actor["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
      </tr>
    <?php } ?>
    </table>
    <br></br>
    <a href="new_actor.php">Add new Actor</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>