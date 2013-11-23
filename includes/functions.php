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
		// will return movie.id  and movie.name in tuples
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


	function basic_movieinfo_in_table($movie_set){  //$movie_set is a virtual table returned by SQL query
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
			$output .=  "<a href=\"movie.php?movieId={$safe_movie_id}\">";
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
		
	function user_dashboard_default_pics() {
		
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
		
?>
