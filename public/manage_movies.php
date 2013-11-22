<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_admin_logged_in(); ?>
<?php
  $movie_set = find_all_movies();
?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php 
  $current_id = htmlentities($_SESSION["admin_id"]); ?>

<div class="hlinks">
   <a href="admin_dashboard.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
	  &nbsp;
  </div>

  <div id="page">
    <?php echo message(); ?>
    <h2>Manage Movies</h2>

    <table>
      <tr>
        <th style="text-align: left; width: 280px;">Movie Name</th>
        <th style="text-align: left; width: 100px;">Year</th>
        <th style="text-align: left; width: 180px;">Director</th>
<!--        <th style="text-align: left; width: 140px;">Picture</th> -->
        <th style="text-align: left; width: 130px;">Rating</th>
      </tr>
    <?php while($movie = mysqli_fetch_assoc($movie_set)) { ?>
      <tr>
        <td><?php echo htmlentities($movie["name"]); ?></td>
        <td><?php echo htmlentities($movie["year"]); ?></td>
		<td><?php echo htmlentities($movie["director"]); ?></td>
		<td><?php echo htmlentities($movie["rating"]); ?></td>

			
        <td><a href="edit_movie.php?id=<?php echo urlencode($movie["id"]); ?>">Edit</a></td>
        <td><a href="delete_movie.php?id=<?php echo urlencode($movie["id"]); ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
      </tr>
    <?php } ?>
    </table>
    <br></br>
    <a href="new_movie.php">Add new movie</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>