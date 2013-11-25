<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php
  $movie_set_empty=false;
  $movie_set = find_recently_released_movie(5); 

  if (!$movie_set ||mysqli_num_rows($movie_set) == 0) {
	  // interested was missing or invalid or 
	  // interested couldn't be found in database
	  $_SESSION["message"] = "Sorry! It seems something wrong with the database.";
  }
  else {
	  $movie_set_empty=true;
  }
  
?>

<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
<a href="user_dashboard.php"><span class="text">Back</span></a>
</div>
</div>


<div id="main" class="wrapper">
  <div id="navigation">
    <a href="user_dashboard.php">&laquo; User Dashboard Home</a><br />
  </div>

  <div id="page">
    
	<?php echo message(); ?>
	<?php if ($movie_set_empty==true) { ?>
	<h3>Movies recently released:  </h3>
	<?php 
		echo basic_movieinfo_with_pic($movie_set);
		
	}
		?>

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>