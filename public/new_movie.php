<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
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
    
    $query  = "INSERT INTO movie (";
    $query .= " name, year, director,picture, rating, introduction, language, studio, duration ";
    $query .= ") VALUES (";
    $query .= "  '{$movie_name}', '{$year}', '{$director}','{$picture}', '{$rating}', '{$introduction}',  '{$language}', '{$studio}', '{$duration}' ";
    $query .= ")";
    $result = mysqli_query($connection, $query);

    if ($result) {
      // Success
      $_SESSION["message"] = "Movie added.";
      redirect_to("manage_movies.php");
    } else {
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
      <td style ="width:290px;"><p>Movie name<br></br>
        <input type="text" name="movie_name" value="" />
      </p></td>
      <td style ="width: 290px;"><p>Year<br></br>
        <input type="text" name="year" value="<?php echo date("Y"); ?>" />
      </p></td>
      <td >
      <p>Director<br></br>
        <input type="text" name="director" value="" />
      </p></td>
      </tr>
 
      <tr>     
      <td >
      <p>Rating<br></br>
        <input type="text" name="rating" value="G" />
      </p></td>
      <td><p>Language<br></br>
        <input type="text" name="language" value="English" />
      </p></td>      
	  <td><p>Picture<br></br>
      <input type="text" name="picture" value="This is default picture." />
      </p></td>
      </tr >
    
      <tr >
      <td >
      <p>Studio<br></br>
        <input type="text" name="studio" value="Studio" />
      </p></td>

      <td><p>Duration<br></br>
        <input type="text" name="duration" value="90" />
      </p></td> </tr >

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
<?php include("../includes/layouts/footer.php"); ?>