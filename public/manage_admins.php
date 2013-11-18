<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $admin_set = find_all_admins();
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
    <h2>Manage Admins</h2>

    <table>
      <tr>
        <th style="text-align: left; width: 150px;">Username</th>
        <th colspan="2" style="text-align: left;width: 200px;">Email</th>
      </tr>
    <?php while($admin = mysqli_fetch_assoc($admin_set)) { ?>
      <tr>
        <td><?php echo htmlentities($admin["name"]); ?></td>
        <td><?php echo htmlentities($admin["email"]); ?></td>

		<?php
         if ($admin["id"] == $current_id) {
        ?>
        <td><a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?>">Edit</a></td>
        <?php } ?>

        <?php
         if ($admin["id"] != $current_id) {
        ?>
        <td><a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
        <?php } ?>
      </tr>
    <?php } ?>
    </table>
    <br></br>
    <a href="new_admin.php">Add new admin</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>