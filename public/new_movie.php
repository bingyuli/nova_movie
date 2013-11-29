<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
// Set autocommit to off
mysqli_autocommit($connection,FALSE);

if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("movie_name", "director","rating","studio");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("movie_name" => 50);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create
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
	if( isset($_POST['genre']) && is_array($_POST['genre']) ) {
	    $genrelist = $_POST['genre'];
	}else{
		$genrelist = null;
	}

    //Post of actors
    $actor = mysql_prep($_POST["actors"]);
    $actorlist = explode(",", $actor);   //arrary of splitting string actors
	
	$result ="";
    //insert to table of movie
    $query  = "INSERT INTO movie (";
    $query .= " name, year, director,picture, rating, introduction, language, studio, duration ";
    $query .= ") VALUES (";
    $query .= "  '{$movie_name}', '{$year}', '{$director}','{$picture}', '{$rating}', '{$introduction}',  '{$language}', '{$studio}', '{$duration}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);
    $movie_id = mysqli_insert_id($connection); 

    if (!$result ) {
      // not Success
      $_SESSION["message"] = "Movie addition failed.";
      redirect_to("manage_movies.php");
    } 
	
    //insert to table of genre
	$max = sizeof($genrelist);
	$result2="";
	for ($i=0; $i<$max; $i++) {
		$query2  = "INSERT INTO genre (";
		$query2 .= " movie_id, type ";
		$query2 .= ") VALUES (";
		$query2 .= "  '{$movie_id}', '{$genrelist[$i]}' ";
		$query2 .= ")";			
	    $result2 = mysqli_query($connection, $query2);		   
	}
    if (!$result2 ) {
      // not Success
      $_SESSION["message"] = "Movie addition failed.";
      redirect_to("manage_movies.php");
    } 

    //insert to table of cast
    //first check if the actor is new actor or not? (if new,  add to actor table first)
	$max = sizeof($actorlist);
	$result3="";
	for ($i=0; $i<$max; $i++) {
		$actor= find_actor_by_name($actorlist[$i]);	
	    if($actor == null){      //check if the actor is new, if new, first add to talbe actor first
		    $query8  = "INSERT INTO actor (";
		    $query8 .= " name, gender ";
			$query8 .= ") VALUES (";
			$query8 .= "  '{$actorlist[$i]}', 'unknown' ";
			$query8 .= ")";				
		    $result8 = mysqli_query($connection, $query8);	
			if($result8){
				$actor_id = mysqli_insert_id($connection); 
			}	
		}
		else {		
		$actor_id = $actor["id"];	}
		
		if($actor_id){			
		    $query3  = "INSERT INTO cast (";
		    $query3 .= " movie_id, actor_id ";
			$query3 .= ") VALUES (";
			$query3 .= "  {$movie_id}, '{$actor_id}' ";
			$query3 .= ")";				
		    $result3 = mysqli_query($connection, $query3);			
			} 		
	
	 } //end of for loop	
	
	if (!$result3 ) {
      // not Success
      $_SESSION["message"] = "Movie addition failed.";
      redirect_to("manage_movies.php");
    } 
    
	
    if ($result && $result2 && $result3) {
      // Success 
      mysqli_commit($connection);  //Commit transaction 
      $_SESSION["message"] = "Movie added.";
      redirect_to("manage_movies.php");
    } 


    else {
      // Failure
      $_SESSION["message"] = "Movie addition failed.";
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
<div class="wrapper">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Add New Movie</h2>
    <form action="new_movie.php" method="post">	     
     
     <table> 
     <tr>
      <td style ="width: 250px;"><p>Movie name<br></br>
        <input type="text" name="movie_name" value="" />
      </p></td>

      <td style ="width: 250px;">
      <p>Director<br></br>
        <input type="text" name="director" value="" />
      </p></td>

      <td style ="width: 350px;"><p>Actors<br></br>
        <input type="text" name="actors" value="" class ="wide"/>
      </p></td>

      </tr>
 
      <tr>     
     
      <td><p>Language<br></br>
        <input type="text" name="language" value="English" />
      </p></td>    

      <td style ="width: 250px;">
      <p>Studio<br></br>
        <input type="text" name="studio" value="Studio" />
      </p></td>
  
	  <td ><p>Picture<br></br>
      <input type="text" name="picture" value="This is picture location." class ="wide" />
      </p></td>
      </tr >
  </table> 

  <table>        
      <tr >
	  <td style ="width:125px;"><p>Year<br></br>
	  <input type="text" name="year" value="<?php echo date("Y"); ?>" class ="small"/>
	  </p>
	
	  <td style ="width: 125px;">
      <p>Rating<br></br>
        <input type="text" name="rating" value="G" class ="small" />
      </p></td>
      <td style ="width: 250px;"><p>Duration<br></br>
        <input type="text" name="duration" value="90" class ="small"/>
      </p></td> 
</tr>
 </table>  

 <table>  	
	 
	  <p>Genre<tr> 
 
	<td><input type="checkbox" name="genre[]" value="Action" class = "narrow"> Action<br></td>

	  <td><input type="checkbox" name="genre[]" value="Adventure" class = "narrow"> Adventure<br></td>
	  <td><input type="checkbox" name="genre[]" value="Comedy" class = "narrow"> Comedy<br></td>
	  <td><input type="checkbox" name="genre[]" value="Crime" class = "narrow"> Crime<br></td>
	  <td><input type="checkbox" name="genre[]" value="Drama" class = "narrow"> Drama<br>	</td>

	  <td><input type="checkbox" name="genre[]" value="Fantasy" class = "narrow"> Fantasy<br></td>
	  <td><input type="checkbox" name="genre[]" value="Horror" class = "narrow"> Horror<br></td>
	  <td><input type="checkbox" name="genre[]" value="Romance" class = "narrow"> Romance<br></td>
	  <td><input type="checkbox" name="genre[]" value="Sci-Fi" class = "narrow"> Sci-Fi<br></td>
	  <td ><input type="checkbox" name="genre[]" value="Thriller" class = "narrow"> Thriller<br></td>	
	  </tr>
	  </p>
 </table>  


<p>Introduction<br></br>
  <textarea name="introduction">introduction of new movie
  </textarea>
</p>	
      <input type="submit" name="submit" value="Add movie" class= "blue"/>
    </form>
    <br />
 </div>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>