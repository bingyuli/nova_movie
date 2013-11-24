<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php  
$movie_name = "";
$movie_year = "";
$actor_name = "";
$movie_genre = "";
$director_name = ""; 
$movie_set=null;
	
if (isset($_POST['submit'])) {
	// get value from post
	$movie_name = mysql_prep($_POST["movie_name"]);
	$movie_year = mysql_prep($_POST["movie_year"]);
	$actor_name = mysql_prep($_POST["actor_name"]);
	$movie_genre = mysql_prep($_POST["movie_genre"]);
	$director_name = mysql_prep($_POST["director_name"]);
	  
	//check fields are valid
	if ($movie_name == "" &&
		  $movie_year == "" &&
		  $actor_name == "" &&
		  $movie_genre == "" &&
		  $director_name == "")//all fields are empty
	   {//set an erro message
		   $_SESSION["message"] = "You should select at least one field.";
		   $movie_set=null;
	   } 

	//search SQL query
	else {  
	$query  = "SELECT * ";
	$query .= "FROM movie M ";	
	$query .= "WHERE M.name LIKE '%{$movie_name}%' ";
	$query .= "AND M.year LIKE '%{$movie_year}%' ";
	$query .= "AND M.director LIKE '%{$director_name}%' ";
	$query .= "AND M.id IN ( ";
	$query .= "SELECT cast.movie_id ";
	$query .= "FROM cast JOIN actor ";
	$query .= "ON cast.actor_id = actor.id ";
	$query .= "WHERE actor.name LIKE '%{$actor_name}%') ";
	$query .= "AND M.id IN ( ";
	$query .= "SELECT genre.movie_id ";
	$query .= "FROM genre ";	
	$query .= "WHERE genre.type LIKE '%{$movie_genre}%'); ";	
	$movie_set = mysqli_query($connection, $query);
	confirm_query($movie_set);
	}

} // end: if (isset($_POST['submit']))

?>


<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="user_dashboard.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main" class="wrapper">
  <div id="navigation">

		<h2>Search Movie: </h2>

		<form action="user_search_movie.php" method="post">

		<p>Movie Name <br></br>
		<input type="text" name="movie_name" value="<?php echo htmlentities($movie_name); ?>" />
		</p>
		<p>Movie Year <br></br>
		<input type="text" name="movie_year" value="<?php echo htmlentities($movie_year); ?>"/>
		</p>
		<p>Actor Name <br></br>
		<input type="text" name="actor_name" value="<?php echo htmlentities($actor_name); ?>" />
		</p>
		<p>Movie Genre <br></br>
		<input type="text" name="movie_genre" value="<?php echo htmlentities($movie_genre); ?>"/>
		</p>
		<p>Director Name <br></br>
		<input type="text" name="director_name" value="<?php echo htmlentities($director_name); ?>" />
		</p>
		<input type="submit" name="submit" value="Start Search" class ="blue"/>

		</form>
		<br />

  </div>

<div style="float: left; height: 100%;padding-left: 15em; vertical-align: top; font-size: 16px; line-height: 15px;" class="wrapper">
    <?php echo message(); ?>
	<?php if ($movie_set) { ?>
	<h3>Movies found:  </h3>
    <?php 
		echo basic_movieinfo_with_pic($movie_set);
		
	?>
	<?php }else {
		echo "<h3> You can search movies now. </h3>";
	}
	?>
 
   </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>