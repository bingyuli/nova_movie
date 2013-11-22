<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php confirm_user_logged_in(); ?>

<?php include("../includes/layouts/header.php"); ?>


<div class="hlinks">
   <a href="user_logout.php"><span class="text">Log Out</span></a>
</div>
<?php find_selected(); //would find selected genre, actor
	//$current_genre=null;
	//$current_actor=null;
	?>

</div>

<div id="main">
  <div id="navigation">
	<br />
	<a href="user_dashboard.php">&laquo; User Dashboard Home</a><br />
	<?php echo movie_navigation($current_genre, $current_actor); 
		?>

<li><a href="edit_user.php">Edit your profile</a></li>
<li><a href="search_movie.php">Search Movie</a></li>
	</ul>

 </div>
     
 <div id="page">
	<h2>User Dashboard</h2>
	<p>Welcome to the Nova Movie, <?php echo htmlentities($_SESSION["user_name"]); ?>.</p>
	
	<?php echo message();?>

	<?php //genre level
		if ($current_genre) { ?>
	<h3>Movies in this genre:</h3>
	<ul>
	<?php 
		$movie_set= find_movies_by_genre_type($current_genre["type"]);
		while($movie= mysqli_fetch_assoc($movie_set)) {
			echo "<li>";
			$safe_movie_id = urlencode($movie["id"]);
			echo "<a href=\"movie.php?movie={$safe_movie_id}\">";
			echo htmlentities($movie["name"]);
			echo "</a>";
			echo "</li>";
		}
		?>
	</ul>
	<br />
	</div>

	<?php }//actor level
		elseif ($current_actor) { ?>
    <h3>Movies of actor: <?php echo $current_actor["name"] ?></h3>
	<ul>
	<?php 
		$movie_set= find_movies_by_actor($current_actor["id"]);
		while($movie= mysqli_fetch_assoc($movie_set)) {
			echo "<li>";
			$safe_movie_id = urlencode($movie["id"]);
			echo "<a href=\"movie.php?movie={$safe_movie_id}\">";
			echo htmlentities($movie["name"]);
			echo "</a>";
			echo "</li>";
		}
		?>
	</ul>
	<br />
	</div>

	<?php } // nothing selected
		else { ?>
	<li><a href="user_edit_profile.php?id=<?php echo urlencode($_SESSION["user_id"]); ?>">Edit your profile</a></li>
	<li><a href="user_search_movie.php">Search Movie</a></li>
	<li><a href="interest_movie.php">Movie in you Interest List</a></li>
	<li><a href="wathed_movie.php">Movie you have watched</a></li>
	<li><a href="recently_release_movie.php">Movie recently released</a></li>
	<?php
		//we can add some default content will be showed in the user dashboard!!!!!
	//like some pictures or the most recently release movie 
	 }?>
	




</div>

</div>
 <?php include("../includes/layouts/footer.php"); ?>