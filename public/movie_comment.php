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
  $comment_set = find_comment_by_movieid($_GET["id"]);  
  if (!$comment_set) {
    // comment was missing or invalid or 
    // comment couldn't be found in database
    redirect_to("manage_movies.php");
  }
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="edit_movie.php?id=<?php echo urlencode($movie["id"]); ?>"><span class="text">Back</span></a>
   <a href="admin_dashboard.php"><span class="text">Admin Dashboard</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    
    <h2>Movie Name: <?php echo htmlentities($movie["name"]); ?></h2>

	    <table>
	      <tr>
	        <th style="text-align: left; width: 160px;">User Name</th>
	        <th style="text-align: left; width: 360px;">Comment</th>
	      </tr>
	
	    <?php while($comment = mysqli_fetch_assoc($comment_set)) { ?>
	      <tr>
	        <td><?php echo htmlentities($comment["name"]); ?></td>
	        <td><?php echo htmlentities($comment["comment"]); ?></td>
<!--        <td><a href="delete_comment.php?id=<?php echo $comment["id"]; ?>" onclick="return confirm('Are you sure?');">Delete</a></td>-->
	      </tr>
	    <?php } ?>
	    </table>




  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>