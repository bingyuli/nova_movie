<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php confirm_user_logged_in(); ?>
<?php
   //find movie by movieId
	$movie_set=null;
	$user_interested=false;//the varialbe determine whether this movie is already in user's interested list
	$user_watched=false; //the varialbe determine whether this movie is already in user's watched list
	global $connection;		
	$safe_movie_id = urlencode($_GET["movieId"]);
	


	
	
	if (isset($_POST['watchMovie'])){

	// insert to table watched,  with user_id and movie_id 
		$query="insert into watched (user_id,movie_id) values ({$_SESSION['user_id']}, {$safe_movie_id}); ";
		$insertresult = mysqli_query($connection, $query);
		confirm_query($insertresult);
	    $_SESSION["message"]="Thank you for watching this movie";
		
	//  add operation to update watched times of movie;
		$query ="update movie set movie.count= ";
		$query .="(select count(*) from watched where movie_id= {$safe_movie_id}); " ;
		$updateresult = mysqli_query($connection, $query);
		confirm_query($updateresult);
	//----will bring an issue, if user watched movie repeatly, dupicated record will be show in watched list!!!!!
	//--need to fix in userdashbord and user_watched_movie.php!!!!!!
	}
	
	if (isset($_POST['addToInterest'])){
	
	// insert to table interested,  with user_id and movie_id 
		$query="insert into interested (user_id,movie_id) values ({$_SESSION['user_id']}, {$safe_movie_id}); ";
		$insertresult = mysqli_query($connection, $query);
		confirm_query($insertresult);
	    $_SESSION["message"]="You have add this movie into your interested list";
	
	}
	
	if (isset($_POST['removeFromInterest'])){
	
	// Delete to table interested,  with user_id and movie_id 
		$query="delete from interested where user_id={$_SESSION['user_id']} AND movie_id= {$safe_movie_id}; ";
		$deleteresult = mysqli_query($connection, $query);
		confirm_query($deleteresult);
	    $_SESSION["message"]="You have remove this movie from your interested list";
	
	}
	
	if (isset($_POST['addReview'])){
		$safe_added_review_value = mysql_prep($_POST["added_review_value"]);
	
		// insert to table review,  with user_id, movie_id, star		
			$query="insert into review (user_id,movie_id,star) values ({$_SESSION['user_id']}, {$safe_movie_id},{$safe_added_review_value}); ";
			$insertresult = mysqli_query($connection, $query);
			confirm_query($insertresult);
			$_SESSION["message"]="Thank you for reviewing this movie ";
			
		//  add operation to update ave_star of movie;	
			$query ="update movie set ave_star = ";
			$query .= "(select AVG(star) from review where movie_id={$safe_movie_id} AND user_id={$_SESSION['user_id']}); ";
			$updateresult = mysqli_query($connection, $query);
			confirm_query($updateresult);
		
	}
	if (isset($_POST['addComment'])){
		$value = trim($_POST["added_comment"]);
		$safe_added_comment = mysql_prep($value);
		if ($_POST["added_comment"]!=""){	
		// insert to table comment,  with user_id, movie_id, comment
			$query="insert into comment (user_id,movie_id,comment) values ({$_SESSION['user_id']}, {$safe_movie_id}, {$safe_added_comment}); ";
			$insertresult = mysqli_query($connection, $query);
			$_SESSION["message"].="Thank your for your comment.";
		}
		else {
			$_SESSION["message"] = "It seems you have not add comment?";
		}
			
	}
	
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
	
	$query3  = "SELECT * ";
	$query3 .= "FROM watched ";
	$query3 .= "WHERE movie_id = {$safe_movie_id} ";
	$query3 .= "AND user_id = {$_SESSION['user_id']} ";
	$query3 .= "LIMIT 1";
	$result3 = mysqli_query($connection, $query3);
	confirm_query($result3);
	if (mysqli_num_rows($result3)>0) {
		$user_watched=true;
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
  <?php echo form_errors($errors); ?>
	
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
			<td><ul><input type="submit" name="removeFromInterest" value="Already interested. Remove?" /></ul></td>
		<?php }?>

		</tr>
		</table>
		</br>


		<h3>Add Comments or review: </h3>
		<?php if ($user_watched) { ?>
		<table>
		<tr>
		<td><input type="radio" name="added_review_value" value="1" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="2" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="3" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="4" class="small"/> </td>
		<td><input type="radio" name="added_review_value" value="5" class="small"<?php  echo "checked"; ?>/> </td>
		</tr>
		<tr>
		<td><ul>1</ul></td>  <td><ul>2</ul></td> <td><ul>3</ul></td> <td><ul>4</ul></td> <td><ul>5</ul></td>
		</tr>
		</table>
		<ul><input type="submit" name="addReview" value="addReview" class="blue"/></ul>
		<?php }?>

       
		<table>
		<tr><td style ="width: 500px;">
		<textarea name="added_comment">
		</textarea>
		</td></tr>
		</table>
		<ul><input type="submit" name="addComment" value="addComment" class="blue"/></ul>
		

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