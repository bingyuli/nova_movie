<?php
//nova_movie functions:	
		
	
	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function mysql_prep($string) {
		global $connection;		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}


	
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
			$output .= "<div class=\"error\">";
			$output .= "Please fix the following errors:";
			$output .= "<ul>";
			foreach ($errors as $key => $error) {
				$output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
			}
			$output .= "</ul>";
			$output .= "</div>";
		}
		return $output;
	}

//functions for user:

	function user_attempt_login($user_email, $password) {
		$user = find_user_by_email($user_email);
		if ($user) {
			// found player, now check password
			if (password_check($password, $user["password"])) {
				// password matches
				return $user;
			} else {
				// password does not match
				return false;
			}
		} else {
			// user not found
			return false;
		}
	}

	function user_logged_in() {
		return isset($_SESSION['user_id']);
	}

		
	function confirm_user_logged_in() {
		
		if (!user_logged_in()) {
			redirect_to("user_login.php");
		}
	}

	function find_user_by_email($user_email) {
		global $connection;
		
		$safe_user_email = mysqli_real_escape_string($connection, $user_email);
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$query .= "WHERE email = '{$safe_user_email}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}

	function password_check($password, $existing_password) {
		if ($password === $existing_password) {
			return true;
		} else {
			return false;
		}
	}

	function find_selected_genre() {  //find selected genre
		global $current_genre;

		if (isset($_GET["genre"])){
			$current_genre = find_genre_by_type ($_GET["genre"]);
		}
		
		else {
			$current_genre = null;
		}
	}

	function find_genre_by_type($genre_type) {
		global $connection;		
		$safe_genre_type = mysqli_real_escape_string($connection, $genre_type);
		
		$query  = "SELECT * ";
		$query .= "FROM genre ";
		$query .= "WHERE type = '{$safe_genre_type}' ";
		$query .= "LIMIT 1";
		$genre_set = mysqli_query($connection, $query);
		confirm_query($genre_set);
		if($genre = mysqli_fetch_assoc($genre_set)) {
			return $genre;
		} else {
			return null;
		}
	}	
	

	function find_all_genres() {
		global $connection;
		
		$query  = "SELECT Distinct type ";
		$query .= "FROM genre ";
		$query .= "ORDER BY type ASC ";
		$genre_set = mysqli_query($connection, $query);
		confirm_query($genre_set);
		return $genre_set;
	}
	
	function find_movies_by_genre_type($genre_type){ 
		 //include genre information in the result
		global $connection;
		$safe_genre_type = mysqli_real_escape_string($connection, $genre_type);
		
		$query  = "SELECT * ";
		$query .= "FROM movie JOIN genre ";
		$query .= "ON movie.id = genre.movie_id ";
		$query .= "WHERE genre.type = '{$safe_genre_type}' ";
		$query .= "ORDER BY movie.name ASC ";
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		return $movie_set;
	}
	
	function find_movies_with_basic_by_genre_type($genre_type){ 
		//use nested query, so no genre information in result, just movie info
		//use this function will solve the problem of comflicting ids in the results of "find_movies_by_genre_tyep()" 
		global $connection;
		$safe_genre_type = mysqli_real_escape_string($connection, $genre_type);
		
		$query  = "SELECT * ";
		$query .= "FROM movie ";
		$query .= "where id in (select movie_id ";
		$query .= "FROM genre ";
		$query .= "WHERE type = '{$safe_genre_type}') ";
		$query .= "ORDER BY movie.name ASC ";
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		return $movie_set;
	}
	
	function find_movies_by_actor($actor_id){ 
	 // will return movie.id  and movie.name in tuples
	 global $connection;
	 $safe_actor_id = mysqli_real_escape_string($connection, $actor_id);
	 
	 $query  = "SELECT * ";
	 $query .= "FROM movie JOIN cast ";
	 $query .= "ON movie.id = cast.movie_id ";
	 $query .= "WHERE cast.actor_id = {$safe_actor_id} ";
	 $query .= "ORDER BY movie.name ASC ";
	 $movie_set = mysqli_query($connection, $query);
	 confirm_query($movie_set);
	 return $movie_set;
	 }
	 

	
	function find_recent_interested_movies_by_user($user_id,$limit_num=50){
		//use nested query,
		//return part of movie info and interested.id, just return recently interested movies in the list
		//$limit_num is the limit number of the top rows in the result
		global $connection;
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
		$query  = "SELECT M.id,M.name,M.year,M.picture,M.ave_star,M.director, M.rating, I.id AS interested_id ";
		$query .= "FROM movie M, interested I ";
		$query .= "where M.id in (select I.movie_id ";
		$query .= "FROM interested ";
		$query .= "WHERE I.user_id = {$safe_user_id}) ";
		$query .= "ORDER BY interested_id DESC ";
		
		$query .= "Limit {$limit_num}; ";
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		return $movie_set;
	}
	
	

	
	function find_recent_watched_movies_by_user($user_id, $limit_num=50){
		//use nested query,
		//return part of movie info and watched.id, just return recently watched movies in the list
		//$limit_num is the limit number of the top rows in the result
		global $connection;
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
//<<<<<<< HEAD
	/*	$query  = "SELECT distinct name, id,year,picture,ave_star,director, rating ";
		$query .= "FROM  watched, movie ";
		$query .= "where movie.id = watched.movie_id ";
		$query .= "AND watched.user_id = {$safe_user_id}) ";
		$query .= "ORDER BY watched.id DESC ";
		$query .= "Limit {$limit_num}; ";
	*/	
		$query  = "SELECT M.id,M.name,M.year,M.picture,M.ave_star,M.director, M.rating, W.id AS watched_id ";
		$query .= "FROM movie M, watched W ";
		$query .= "where M.id in (select W.movie_id ";
		$query .= "FROM watched ";
		$query .= "WHERE W.user_id = {$safe_user_id}) ";
		$query .= "ORDER BY watched_id DESC ";
//=======
//		$query  = "SELECT M.id,M.name,M.year,M.picture,M.ave_star,M.director, M.rating, W.id AS watched_id ";
//		$query .= "FROM movie M, watched W ";
//		$query .= "where M.id in (select Distinct W.movie_id ";
//		$query .= "FROM watched ";
//		$query .= "WHERE W.user_id = {$safe_user_id}) ";
		
		
		//The following is Qi added
//		$query  = "SELECT DISTINCT M.id,M.name,M.year,M.picture,M.ave_star, M.director, M.rating ";
//		$query .= "FROM movie M, watched W ";
//		$query .= "WHERE M.id = movie_id AND  W.user_id = {$safe_user_id}  ORDER BY W.id DESC ";

				
//    	$query .= "ORDER BY watched_id DESC ";
//>>>>>>> 7e1d1d57ce901dcb69031bd9b0b33ed781d402f3
		$query .= "Limit {$limit_num}; ";
		
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		return $movie_set;
	}
	
	function find_recently_released_movie($limit_num=50){
		//return movie info of recently released movies
		//$limit_num is the limit number of the top rows in the result
		global $connection;
		$query ="select id, name, year, picture, ave_star, director,rating from movie ";
		$query .="Order by id desc ";
		$query .= "Limit {$limit_num}; ";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		return $result;
	}
		
	function find_most_popular_movie($limit_num=50){
		//return movie info of most popular movies
		//$limit_num is the limit number of the top rows in the result
		global $connection;
		$query ="select id, name, year, picture, ave_star, director,rating from movie ";
		$query .="Order by count desc ";
		$query .= "Limit {$limit_num}; ";
		$result = mysqli_query($connection, $query);
		confirm_query($result);
		return $result;
	}
	
	function movie_navigation($genre_array) {
		
		// show genres:
		$output = "<ul class=\"subjects\">";
		$output .= "Genres:";
		$output .= "</ul>";
		
		$output .= "<ul class=\"pages\">";
		$genre_set = find_all_genres();
		while($genre = mysqli_fetch_assoc($genre_set)) {
			$output .= "<li";
			if ($genre_array && $genre["type"] == $genre_array["type"]) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"user_dashboard.php?genre=";
			$output .= urlencode($genre["type"]);
			$output .= "\">";
			$output .= htmlentities($genre["type"]);
			$output .= "</a>";
			$output .= "</li>"; // end of the genre li
		}
		$output .= "</ul>";
		mysqli_free_result($genre_set);
		return $output;
	}


	function basic_movieinfo_in_table($movie_set){  //view function
		//$movie_set is a virtual table returned by SQL query
		$output = "<table border=\"1\"> ";
		$output .= "<tr>";
		$output .= "<th>Title</th>";
		$output .= "<th>Year</th>";
		$output .= "<th>Director</th>";
		$output .= "<th>Rating</th>";
		$output .= "</tr>";
		
		while($movie= mysqli_fetch_assoc($movie_set)) {
			$output .= "<tr>";
			$output .=  "<td>";
			$safe_movie_id = urlencode($movie["id"]);
			$output .=  "<a href=\"user_movie.php?movieId={$safe_movie_id}\">";
			$output .=  htmlentities($movie["name"]);
			$output .=  "</a>";
			$output .=  "</td>";
			$output .=  "<td>";
			$output .=  $movie["year"];
			$output .= "</td>";
			$output .= "<td>";
			$output .=  $movie["director"];
			$output .=  "</td>";
			$output .=  "<td>";
			$output .=  $movie["rating"];
			$output .=  "</td>";
			$output .=  "</tr>";
		}
		$output .=   "</table>"; 
		return $output;
	}
		
	
	function basic_movieinfo_with_pic($movie_set,$pic_width=120,$pic_height=160,$detailed='false'){  //view function
		//$movie_set is a virtual table just contain movie info returned by SQL query, contain movie id, name.....
		//this function will show all basic info of movie and actors, genre 
		//$pic_width,$pic_height to set the size of picture
		global $connection;
		$output = "<table> ";
		
		while($movie= mysqli_fetch_assoc($movie_set)) {
			$output .= "<tr>";
			$output .= "<td width=\"{$pic_width}px\"><img src='".$movie['picture']."' width=\"{$pic_width}px\" height=\"{$pic_height}px\"/></td>";
			$output .= "<td width=\"500px\">";
			$output .= "<ul>";
			$safe_movie_id = urlencode($movie['id']);
			$output .=  "<h3><a href=\"user_movie.php?movieId={$safe_movie_id}\">";
			$output .=  htmlentities($movie['name']);
			$output .=  "</a></h3>";
			$output .= "<li><strong>Average Star:&nbsp</strong> ".$movie['ave_star']."</li></br>";
			$output .= "<li><strong>Year:&nbsp</strong> ".$movie['year']."</li></br>";
			$output .= "<li><strong>Director:&nbsp</strong> ".$movie['director']."</li></br>";
			$output .= "<li><strong>Rating:&nbsp</strong> ".$movie['rating']."</li></br>";
			
			$output .= "<li><strong>Actor:&nbsp</strong>";  //show actor
			$query3 = "select name from actor where id in (select actor_id from cast where movie_id = {$safe_movie_id})";
			$result3 = mysqli_query($connection, $query3);
			confirm_query($result3);
			$num = mysqli_num_rows($result3);
			while ($actor = mysqli_fetch_assoc($result3))
			{		
				$output .= "".$actor['name']."";
				if ( $num-1 >0 )
				{
					$output .= ",&nbsp";
					$num--;
				}
				
			}
			$output .= "</li></br>";
			
			$output .="<li><strong>Genre:&nbsp</strong>"; //show Genre
			$query4 = "select type from genre where movie_id = {$safe_movie_id}";
			$result4= mysqli_query($connection, $query4);
			$num = mysqli_num_rows($result4);
			while ( $genre = mysqli_fetch_assoc($result4))
			{
				$output .="".$genre['type']."";
				if ( $num-1 >0 )
				{
					$output .= ",&nbsp";
					$num--;
				}
			}
			$output .= "</li></br>";
			
			if($detailed=='true'){//if the movie need to be showed in detailed,  show introduction 
				$output .="<li><strong>Introduction:&nbsp</strong></br> ".$movie['introduction']."</li></br>";
				$output .="<li><strong>Movie Watched Times:&nbsp</strong> ".$movie['count']."</li></br>";
			}
	
			$output .=  "</ul>";
			$output .=  "</td>";
			$output .=  "</tr>";
		}
		$output .=   "</table>"; 
		
			
		return $output;
	}
	
	function movie_name_with_pic($movie_set){//view function
		//just show movie name (as a link) and movie picture
		global $connection;
		$output = "<table> ";
		$output .= "<tr>";
		while($movie= mysqli_fetch_assoc($movie_set)) {
			
			$output .= "<td width=\"150px\ height=\"200px\" > <img src='".$movie['picture']."' width=\"120px\" height=\"160px\" /> ";
			//$output .= "<ul>";
			$safe_movie_id = urlencode($movie["id"]);
			$output .=  "<a href=\"user_movie.php?movieId={$safe_movie_id}\">";
			$output .=  htmlentities($movie['name']);
			//$output .= " \"/> ";
			$output .=  "</a></td>";
		}
		$output .=   "</tr></table>"; 
		
		
			
		return $output;
	}
	
	function comment_of_movie_in_table($comment_set){//view function
		$output = "<table> ";
		$output .= "<tr>";
		$output .= "<th style=\"text-align: left; width: 160px;\">User Name</th> ";
		$output .= "<th style=\"text-align: left; width: 360px;\">Comment</th> ";
		$output .= "</tr>";
		while($comment= mysqli_fetch_assoc($comment_set)) {
			$output .= "<tr>";
			$output .= "<td> ";	
		    $output .=  htmlentities($comment['name']);
			$output .=  "</td>";
			$output .= "<td> ";	
		    $output .=  htmlentities($comment['comment']);
			$output .=  "</td>";
			$output .=  "</tr>";
		}
		$output .=   "</table>"; 
		
		return $output;
		
	}
	
	function user_dashboard_default_pics() {//view function
		
	    $output ="<img src=\"http://pic1a.nipic.com/2008-09-11/2008911114038528_2.jpg\" 
		alt=\"Family\" width=\"150\" height=\"150\"> ";
		$output .="<img src=\"image/background.jpg\" 
		alt=\"Family\" width=\"200\" height=\"150\"> ";
		return $output;
	
	}

	
	
// functions for admin
	
	
	function find_admin_by_email($admin_email) {
		global $connection;
		
		$safe_admin_email = mysqli_real_escape_string($connection, $admin_email);
		
		$query  = "SELECT * ";
		$query .= "FROM administrator ";
		$query .= "WHERE email = '{$safe_admin_email}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}


	function admin_attempt_login($admin_email, $password) {
		$admin = find_admin_by_email($admin_email);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}


	function confirm_admin_logged_in() {
		if (!admin_logged_in()) {
			redirect_to("admin_login.php");
		}
	}


	function admin_logged_in() {
		return isset($_SESSION['admin_id']);
	}


	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM administrator ";
		$query .= " ORDER BY name ";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	
	function find_all_actors() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM actor ";
		$query .= " ORDER BY name ";
		$actor_set = mysqli_query($connection, $query);
		confirm_query($actor_set);
		return $actor_set;
	}
	
	function find_all_users() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$query .= " ORDER BY name ";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		return $user_set;
	}
	
	function find_all_movies() {
		global $connection;		
		$query  = "SELECT * ";
		$query .= "FROM movie ";
		$query .= " ORDER BY name ";
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		return $movie_set;
	}
	
	function find_admin_by_id($admin_id) {
		global $connection;		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM administrator ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}	
	
	function find_actor_by_id($actor_id) {
		global $connection;		
		$safe_actor_id = mysqli_real_escape_string($connection, $actor_id);
		
		$query  = "SELECT * ";
		$query .= "FROM actor ";
		$query .= "WHERE id = {$safe_actor_id} ";
		$query .= "LIMIT 1";
		$actor_set = mysqli_query($connection, $query);
		confirm_query($actor_set);
		if($actor = mysqli_fetch_assoc($actor_set)) {

			return $actor;
		} else {
			return null;
		}

	}				
			
	function find_actor_by_name($name) {
		global $connection;				
		$query  = "SELECT id ";
		$query .= "FROM actor ";
		$query .= "WHERE name = '{$name}' ";
		$query .= "LIMIT 1";
		$actor_id = mysqli_query($connection, $query);
		confirm_query($actor_id);
		if($actor = mysqli_fetch_assoc($actor_id)) {
			return $actor;
		} else {
			return null;
		}

	}		
			
			
	
	function find_user_by_id($user_id) {
		global $connection;		
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$query .= "WHERE id = {$safe_user_id} ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}	
	
	function find_movie_by_id($movie_id) {
		global $connection;		
		$safe_movie_id = mysqli_real_escape_string($connection, $movie_id);
		
		$query  = "SELECT * ";
		$query .= "FROM movie ";
		$query .= "WHERE id = {$safe_movie_id} ";
		$query .= "LIMIT 1";
		$movie_set = mysqli_query($connection, $query);
		confirm_query($movie_set);
		if($movie = mysqli_fetch_assoc($movie_set)) {
			return $movie;
		} else {
			return null;
		}
	}	

	function find_watched_movie($user_id) { 		
	// will return movie.id  and movie.name in tuples
		global $connection;		   
		$safe_user_id = mysqli_real_escape_string($connection, $user_id);
		//$id = 2;
		$query  = "SELECT movie.name, movie.id ";
		$query .= "FROM watched JOIN movie ";
		$query .= "ON watched.movie_id = movie.id ";
		$query .= "WHERE watched.user_id = {$safe_user_id} ";
		//$query .= "WHERE user_id = {$id} ";
		$query .= "ORDER BY watched.id DESC ";
		$query .= "LIMIT 3";
		//$query .= "LIMIT 0, 3";
		//echo $query;
		// echo "<br />";
		$watched_set = mysqli_query($connection, $query);
		confirm_query($watched_set);
		return $watched_set;
		/*if($watched = mysqli_fetch_assoc($watched_set)) {
			return $watched;
		} else {
			return null;
		}	*/ 
	}	
	
	function find_movie_by_name($name){ 
	 // will return movie.id
	 global $connection;
	 $query  = "SELECT id ";
	 $query .= "FROM movie ";
	 $query .= "WHERE name = '{$name}' ";
	 $movie_id = mysqli_query($connection, $query);
	 confirm_query($movie_id);
	 return $movie_id;
	 }	
	
	function find_actor_by_movieid($movie_id){
	// will return actor names by movie_id
	global $connection;
	$query  = "SELECT DISTINCT name ";
	$query .= "FROM actor, cast ";
	$query .= " WHERE movie_id = '{$movie_id}' ";
	$query .= " AND actor_id = actor.id ";
	$actor_set = mysqli_query($connection, $query);
    confirm_query($actor_set);
	return $actor_set;
	}
	
	function find_genre_by_movieid($movie_id){
	// will return genre type by movie_id
	global $connection;
	$query  = "SELECT DISTINCT type ";
	$query .= "FROM genre ";
	$query .= " WHERE movie_id = '{$movie_id}' ";
	$genre_set = mysqli_query($connection, $query);

    confirm_query($genre_set);
	return $genre_set;
	}
	
	function find_comment_by_movieid($movie_id){
	// will return the user name and comment by movie_id
	global $connection;
	$query  = "SELECT comment.id, name, comment  ";
	$query .= "FROM user, comment ";
	$query .= " WHERE movie_id = '{$movie_id}' ";
	$query .= " AND user.id = user_id ";
	$comment_set = mysqli_query($connection, $query);

    confirm_query($comment_set);
	return $comment_set;
	}
	
	function find_review_by_movieid($movie_id){
	// will return the user name and review by movie_id
	global $connection;
	$query  = "SELECT review.id, name, star  ";
	$query .= "FROM user, review ";
	$query .= " WHERE movie_id = '{$movie_id}' ";
	$query .= " AND user.id = user_id ";
	$review_set = mysqli_query($connection, $query);

    confirm_query($review_set);
	return $review_set;
	}
	
	function find_watched_by_userid($user_id){
	// will return the watched movie name  by user_id
	global $connection;
	$query  = "SELECT DISTINCT  watched.id, name ";
	$query .= "FROM movie, watched ";
	$query .= " WHERE user_id = '{$user_id}' ";
	$query .= " AND movie.id = movie_id ";
	$watched_set = mysqli_query($connection, $query);

    confirm_query($watched_set);
	return $watched_set;
	}		
	
	function find_interested_by_userid($user_id){
	// will return the interested movie name  by user_id
	global $connection;
	$query  = "SELECT DISTINCT  interested.id, name ";
	$query .= "FROM movie, interested ";
	$query .= " WHERE user_id = '{$user_id}' ";
	$query .= " AND movie.id = movie_id ";
	$interested_set = mysqli_query($connection, $query);
    confirm_query($interested_set);
	return $interested_set;
	}						
?>