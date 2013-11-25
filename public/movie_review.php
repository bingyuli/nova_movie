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
  $review_set = find_review_by_movieid($_GET["id"]);  
  if (!$review_set) {
    // review  was missing or invalid or 
    // reviewcouldn't be found in database
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
	        <th style="text-align: left; width: 360px;">Star</th>
	      </tr>
	
	    <?php while($review = mysqli_fetch_assoc($review_set)) { ?>
	      <tr>
	        <td><?php echo htmlentities($review["name"]); ?></td>
	        <td><?php echo htmlentities($review["star"]); ?></td>
<!--        <td><a href="delete_comment.php?id=<?php echo $review["id"]; ?>" onclick="return confirm('Are you sure?');">Delete</a></td> -->
	      </tr>
	    <?php } ?>
	    </table>

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>