<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $movie = find_movie_by_id($_GET["id"]);
  if (!$movie) {
    // movieID was missing or invalid or 
    // movie couldn't be found in database
    redirect_to("manage_users.php");
  }
  
  $id = $movie["id"];
  $query = "DELETE FROM movie WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Movie deleted.";
    redirect_to("manage_movies.php");
  } else {
    // Failure
    $_SESSION["message"] = "Movie deletion failed.";
    redirect_to("manage_movies.php");
  }  
?>