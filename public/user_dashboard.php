<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>



<?php include("../includes/layouts/header.php"); ?>
   
<div class="hlinks">
   <a href="user_logout.php"><span class="text">Log Out</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
	

 </div>
     
 <div id="page">
	<h2>User Dashbord</h2>
	<p>Welcome to the Nova Movie, <?php echo htmlentities($_SESSION["user_name"]); ?>.</p>
	<ul>
	<li><a href="edit_user.php">Edit your profile</a></li>
<br> </br>
	<li><a href="search_movie.php">Search Movie</a></li>

	</ul>



</div>

</div>
 <?php include("../includes/layouts/footer.php"); ?>