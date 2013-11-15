<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>


<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
   
<div class="hlinks">
   <a href="index.php"><span class="text">Log Out</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
	<ul class = "subjects">
		<a href="admin_dashboard?subject1">Manage Admin</a>
	</ul>
		
	<ul class = "subjects">
		<a href="admin_dashboard?subject2">Manage User</a>
	</ul>

	<ul class = "subjects">
		<a href="admin_dashboard?subject3">Manage Movie</a>
	</ul>
	
	<ul class = "subjects">
		<a href="admin_dashboard?subject4">Manage Actor</a>
	</ul>

</div>
     
<div id="page">

  </div>
</div>
 <?php include("../includes/layouts/footer.php"); ?>