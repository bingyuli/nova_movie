<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php
  $movie_set_empty=false;
  $interested_set = find_recent_interested_movies_by_user($_SESSION["user_id"]); 

  if (!$interested_set ||mysqli_num_rows($interested_set) == 0) {
	  // interested was missing or invalid or 
	  // interested couldn't be found in database
	  $_SESSION["message"] = "It seems you have no movie in your interested list";
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
	<h3>Movies you are interested in:  </h3>
	<?php 
		echo basic_movieinfo_with_pic($interested_set);
		
	}
		?>

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>