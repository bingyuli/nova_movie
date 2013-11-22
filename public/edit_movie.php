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

    if ($result && mysqli_affected_rows($connection) == 1) {
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
      <td style ="width:290px;"><p>Movie Name<br></br>
        <input type="text" name="movie_name" value="<?php echo htmlentities($movie["name"]); ?>" />
      </p></td>
      <td style ="width: 290px;"><p>Year<br></br>
        <input type="text" name="year" value="<?php echo htmlentities($movie["year"]); ?>" />
      </p></td>
      <td >
      <p>Director<br></br>
        <input type="text" name="director" value="<?php echo htmlentities($movie["director"]); ?>" />
      </p></td>
      </tr>

      <tr>     
      <td >
      <p>Rating<br></br>
        <input type="text" name="rating" value="<?php echo htmlentities($movie["rating"]); ?>" />
      </p></td>
      <td><p>Language<br></br>
        <input type="text" name="language" value="<?php echo htmlentities($movie["language"]); ?>" />
      </p></td>      
	  <td><p>Picture<br></br>
      <input type="text" name="picture" value="<?php echo htmlentities($movie["picture"]); ?>" />
      </p></td>
      </tr >

     <tr >
      <td >
      <p>Studio<br></br>
        <input type="text" name="studio" value="<?php echo htmlentities($movie["studio"]); ?>" />
      </p></td>

      <td><p>Duration<br></br>
        <input type="text" name="duration" value="<?php echo htmlentities($movie["duration"]); ?>" />
      </p></td> </tr >

      </table> 
      <p>Introduction<br></br>
	    <textarea name="introduction"><?php echo htmlentities($movie["introduction"]); ?>
	    </textarea>
	  </p>

      <input type="submit" name="submit" value="Edit Movie" class="blue" />
    </form>
    <br />
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>