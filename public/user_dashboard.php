<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="user_edit_profile.php?id=<?php echo urlencode($_SESSION["user_id"]); ?>"><span class="text">
	Edit Your Profile: <?php echo urlencode($_SESSION["user_name"]); ?> </a></li>
   <a href="user_logout.php"><span class="text">Log Out</span></a>
</div>

<?php 
	$found_user = find_user_by_id($_SESSION["user_id"]); //find user
	find_selected_genre();//would find selected genre
?>

</div>

<div id="main">

  <div id="navigation">
	<br />
	<a href="user_dashboard.php">&laquo; User Dashboard Home</a><br />


	<?php //if user not expired
		if ($found_user["expired"]==0){ 
			echo movie_navigation($current_genre); ?>
	
			<li><a href="user_search_movie.php">Search Movie</a></li>
			<li><a href="user_interested_movie.php">Movie in you Interest List</a></li>
			<li><a href="user_watched_movie.php">Movie you have watched</a></li>
			<li><a href="user_recently_released_movie.php">Movie recently released</a></li>
			


	<?php }
		else {
			$_SESSION["message"]="Your status is expired, do you want to make a payment? ";
		}
		?>
	

 </div>
     
 <div id="page" class="wrapper">
	<h2>User Dashboard</h2>
	<p>Welcome to the Nova Movie, <?php echo htmlentities($_SESSION["user_name"]); ?>.</p>
	
	<?php echo message();?>

	<?php //if user is expired
		if ($found_user["expired"]==1){ ?>
			<a href="user_make_payment.php">Make a payment</a>
			</div>


	<?php } //genre selected
		elseif ($current_genre) { ?>
	<h3>Movies in the genre: <?php echo htmlentities($current_genre["type"]) ?> </h3>
	<ul>

	<?php 
		$movie_set= find_movies_with_basic_by_genre_type($current_genre["type"]);
		echo basic_movieinfo_with_pic($movie_set);
		?>

    </ul>
	<br />
 </div>     

	<?php } // nothing selected
		else { ?>
		<h3>Movies recently released:</h3>	
		<ul>
		<?php	
			$recently_released_movie_set = find_recently_released_movie(5); 
			echo movie_name_with_pic($recently_released_movie_set);
			?>

		</ul>	

		<h3>Movies you are interested:</h3>	
		<ul>
		<?php	
			$interested_movie_set = find_recent_interested_movies_by_user($_SESSION["user_id"],5); 
			echo movie_name_with_pic($interested_movie_set);
	    ?>
        </ul>

		<h3>Movies you have watched:</h3>	
		<ul>
		<?php	
			$watched_movie_set = find_recent_watched_movies_by_user($_SESSION["user_id"],5); 
			echo movie_name_with_pic($watched_movie_set);
			?>
		</ul>

<br></br>

 </div>   
	<?php  }  ?>
	

 <?php include("../includes/layouts/footer.php"); ?>