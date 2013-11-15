<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="admin_logout.php"><span class="text">Sign Out</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">
    <h2>Admin Menu</h2>
    <p>Welcome to the admin area, <?php echo htmlentities($_SESSION["admin_name"]); ?>. 	<br> </br> </p>
      <ul>
      <li><a href="manage_admins.php">Manage Administrators </a></li>
      <br> </br>   
      <li><a href="manage_users.php">Manage Users</a></li>
      <br> </br>   
      <li><a href="manage_movies.php">Manage Movies</a></li>
      <br> </br>   
      <li><a href="manage_actors.php">Manage Actors</a></li>
      <br> </br>    
      </ul>

  </div>
</div>

 <?php include("../includes/layouts/footer.php"); ?>