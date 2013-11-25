<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php
   //find movie by movieId
	$movie_set=null;
	$user_interested=false; //the varialbe determine whether this movie is already in user's interested list
	global $connection;		
	$safe_movie_id = urlencode($_GET["movieId"]);
	
	//if (isset(_POST['watchMovie'])){
	//  add operation to update watched times of movie;
	    // insert to table watched,  with user_id and movie_id  
	// set $_SESSION["message"]="Thank you for watching this movie"
	//----will bring an issue, if user watched movie repeatly, dupicated record will be show in watched list!!!!!
	//}
	
	//if (isset(_POST['addToInterest'])){
	
	// insert to table interested,  with user_id and movie_id  
	// $_SESSION["message"]="You have add this movie into your interested list"
	//
	//}
	
	//if (isset(_POST['removeFromInterest'])){
	
	// Delete to table interested,  with user_id and movie_id  
	// $_SESSION["message"]="You have remove this movie from your interested list"
	//
	//}
	
	//if (isset(_POST['addReviewComment'])){
	//  add operation to update ave_star of movie;
	// insert to table review,  with user_id, movie_id, star
	// insert to table comment,  with user_id, movie_id, comment
	// $_SESSION["message"]="You have reviewed or commented on this movie"
	//
	//}
	
	$query  = "SELECT * ";
	$query .= "FROM movie ";
	$query .= "WHERE id = {$safe_movie_id} ";
	$query .= "LIMIT 1";
	$movie_set = mysqli_query($connection, $query);
	confirm_query($movie_set);
	
	$query2  = "SELECT * ";
	$query2 .= "FROM interested ";
	$query2 .= "WHERE movie_id = {$safe_movie_id} ";
	$query2 .= "AND user_id = {$_SESSION['user_id']} ";
	$query2 .= "LIMIT 1";
	$result2 = mysqli_query($connection, $query2);
	confirm_query($result2);
	if (mysqli_num_rows($result2)>0) {
		$user_interested=true;
	}


?>

<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
<a href="user_profile.php?id=<?php echo urlencode($_SESSION["user_id"]); ?>"><span class="text">
<?php echo urlencode($_SESSION["user_name"]); ?> </a></li>
<a href="user_dashboard.php"><span class="text">Back</span></a>
</div>
</div>


<div id="main" class="wrapper">
  <div id="navigation">
    <a href="user_dashboard.php">&laquo; User Dashboard Home</a><br />
  </div>

  <div id="page">
    
   <?php echo message(); ?>
	
     <h3>Detailed information about this movie:  </h3>
	<?php 
		echo basic_movieinfo_with_pic($movie_set,200,350,true);
		?>

	
	<form action="user_movie.php?movieId=<?php echo $safe_movie_id; ?>" method="post">
		<table>
		<tr>
			<td><ul><input type="submit" name="watchMovie" value="Watch Movie" class="blue"/></ul></td>

		<?php if (!$user_interested) { ?>
			<td><ul><input type="submit" name="addToInterest" value="Add to interested list" class="blue"/></ul></td>
		<?php }?>
		<?php if ($user_interested) { ?>
			<td><ul><input type="submit" name="removeFromInterest" value="Remove interested " class="blue"/></ul></td>
		<?php }?>

		</tr>
		</table>
		</br>


		<h3>Add Comments and review: </h3>
		<table>
		<tr><td style ="width: 500px;">
		<textarea name="added_comment" value ="You can add your comment here" ?>
		</textarea>
		</td></tr>
		</table>

		<table>
		<tr>
		<td><input type="radio" name="added_review_value" value="1" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="2" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="3" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="4" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="5" class="small"/> </td>
		</tr>
		<tr>
		<td><ul>1</ul></td>  <td><ul>2</ul></td> <td><ul>3</ul></td> <td><ul>4</ul></td> <td><ul>5</ul></td>
		</tr>
		</table>

		<ul><input type="submit" name="addReviewComment" value="submit" class="blue"/></ul>

	</form>

	 <h3>Comments about this movie:  </h3>
	<?php 
		$comment_set=find_comment_by_movieid($safe_movie_id);
		echo comment_of_movie_in_table($comment_set);
	?>
	<br /><br />

  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>