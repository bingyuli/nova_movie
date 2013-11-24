<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $movie = find_movie_by_id($_GET["id"]);  
  if (!$movie) {
    // movie ID was missing or invalid or 
    // movie couldn't be found in database
    redirect_to("manage_movies.php");
  }
?>
<?php
  $actor_set = find_actor_by_movieid($_GET["id"]);
  if (!$actor_set) {
    // movie without actor
    redirect_to("manage_movies.php");
  }
   
  $actorname ="";
  while($actors = mysqli_fetch_assoc($actor_set)) { 
	
	$actorname .= $actors["name"];
	$actorname .= ",";	
	}   
?>
<?php
  $genre_set = find_genre_by_movieid($_GET["id"]);
  if (!$genre_set) {
    // movie without genre
    redirect_to("manage_movies.php");
  }   

  $genres ="";
  while($genre = mysqli_fetch_assoc($genre_set)) { 
	
	$genres .= $genre["type"];
	$genres .= ",";	
	}   
?>
<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("movie_name","director","rating","studio");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("movie_name" =>50);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $id = $movie["id"];
    $movie_name = mysql_prep($_POST["movie_name"]);
    $year =mysql_prep($_POST["year"]);
    $director = mysql_prep($_POST["director"]);
    $picture =mysql_prep($_POST["picture"]);
    $rating =mysql_prep($_POST["rating"]);
    $introduction =mysql_prep($_POST["introduction"]);
    $language =mysql_prep($_POST["language"]);
    $studio =mysql_prep($_POST["studio"]);
    $duration =mysql_prep($_POST["duration"]);

    //Post of genre
    $genre = mysql_prep($_POST["genre"]);
    $genrelist = explode(",", $genre);   //arrary of splitting string

    //Post of actors
    $actor = mysql_prep($_POST["actors"]);
    $actorlist = explode(",", $actor);   //arrary of splitting string actors
    

    $query  = "UPDATE movie SET ";
    $query .= "name = '{$movie_name}', ";
    $query .= "year = '{$year}', ";
    $query .= "director = '{$director}', ";
    $query .= "picture = '{$picture}', ";
    $query .= "rating = '{$rating}', ";
    $query .= "language = '{$language}', ";
    $query .= "studio = '{$studio}', ";
    $query .= "duration = '{$duration}', ";
    $query .= "introduction = '{$introduction}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    //insert to table of genre
	$max = sizeof($genrelist);
	for ($i=0; $i<$max; $i++) {
		$query2  = "INSERT INTO genre (";
		$query2 .= " movie_id, type ";
		$query2 .= ") VALUES (";
		$query2 .= "  {$id}, '{$genrelist[$i]}' ";
		$query2 .= ")";			
	    $result2 = mysqli_query($connection, $query2);		   
	}

    //insert to table of cast
    //first check if the actor is new actor or not? (if new, must add to actor table first)
	$max = sizeof($actorlist);
	for ($i=0; $i<$max; $i++) {
	$actor= find_actor_by_name($actorlist[$i]);
	$actor_id = $actor["id"];
	if($actor_id){			
	    $query3  = "INSERT INTO cast (";
	    $query3 .= " movie_id, actor_id ";
		$query3 .= ") VALUES (";
		$query3 .= "  {$id}, '{$actor_id}' ";
		$query3 .= ")";				
	    $result3 = mysqli_query($connection, $query3);			
		} 		
	}
	
    if ($result) {
      // Success
      $_SESSION["message"] = "Movie updated.";
      redirect_to("manage_movies.php");
    } else {
      // Failure
      $_SESSION["message"] = "Movie update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))
?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="manage_movies.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit Movie: <?php echo htmlentities($movie["name"]); ?></h2>
    <form action="edit_movie.php?id=<?php echo urlencode($movie["id"]); ?>" method="post">
     
     <table> 
     <tr>
      <td style ="width: 250px;">
	  <p>Movie Name<br></br>
        <input type="text" name="movie_name" value="<?php echo htmlentities($movie["name"]); ?>" />
      </p></td>     

      <td style ="width: 250px;">
      <p>Director<br></br>
        <input type="text" name="director" value="<?php echo htmlentities($movie["director"]); ?>" />
      </p></td>

     <td style ="width: 350px;"><p>Actors<br></br>
        <input type="text" name="actors" value="<?php echo $actorname; ?>" class ="wide"/>
      </p></td>

      <td style ="width: 100px;"><p>Year<br></br>
        <input type="text" name="year" value="<?php echo htmlentities($movie["year"]); ?>" class ="small"/>
      </p></td>   
      </tr>	

      <tr>  
	  <td><p>Language<br></br>
	  <input type="text" name="language" value="<?php echo htmlentities($movie["language"]); ?>" />
	  </p></td>
	
	  <td style ="width: 250px;">
      <p>Studio<br></br>
        <input type="text" name="studio" value="<?php echo htmlentities($movie["studio"]); ?>" />
      </p></td>
    
	  <td style ="width: 350px;"><p>Picture<br></br>
      <input type="text" name="picture" value="<?php echo htmlentities($movie["picture"]); ?>" class ="wide"/>
      </p></td>

      <td style ="width: 100px;">
      <p>Rating<br></br>
        <input type="text" name="rating" value="<?php echo htmlentities($movie["rating"]); ?>" class ="small"/>
      </p></td>
     </tr >

     <tr >
	  <td><p>Genre<br></br>
	  <input type="text" name="genre" value="<?php echo $genres; ?>" />
	  </p></td>
	
      <td><p>Duration<br></br>
        <input type="text" name="duration" value="<?php echo htmlentities($movie["duration"]); ?>" class ="small"/>
      </p></td> 
  
	  <td style ="width: 150px;"><p>Watched Count<br></br>
	  <input type="text" name="count" value="<?php echo htmlentities($movie["count"]); ?>"class ="small" />
	  </p></td>
	
	  <td><p>Average Star<br></br>
	  <input type="text" name="ave_star" value="<?php echo htmlentities($movie["ave_star"]); ?>" class ="small"/>
	  </p></td>	
	 </tr >
	   </table> 
	   <table> 		
     <tr>
       <td style ="width: 500px;"><p>Introduction<br></br>
	    <textarea name="introduction"><?php echo htmlentities($movie["introduction"]); ?>
	    </textarea>
	  </p> </td>
	
	  <td style ="width: 100px;"><a href="movie_comment.php?id=<?php echo urlencode($movie["id"]); ?>">Comment</a></td>
	
      <td><a href="movie_review.php?id=<?php echo urlencode($movie["id"]); ?>">Review</a></td>
	   </tr>
	   </table> 

      <input type="submit" name="submit" value="Edit Movie" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>