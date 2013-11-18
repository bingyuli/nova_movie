<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $actor = find_actor_by_id($_GET["id"]);
  if (!$actor) {
    // actorID was missing or invalid or 
    // actor couldn't be found in database
    redirect_to("manage_actors.php");
  }
  
  $id = $actor["id"];
  $query = "DELETE FROM actor WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Actor deleted.";
    redirect_to("manage_actors.php");
  } else {
    // Failure
    $_SESSION["message"] = "Actor deletion failed.";
    redirect_to("manage_actors.php");
  }
  
?>
