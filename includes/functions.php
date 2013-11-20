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
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	
	function find_all_actors() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM actor ";
		$actor_set = mysqli_query($connection, $query);
		confirm_query($actor_set);
		return $actor_set;
	}
	
	function find_all_users() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM user ";
		$user_set = mysqli_query($connection, $query);
		confirm_query($user_set);
		return $user_set;
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
?>