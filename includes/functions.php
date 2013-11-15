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


	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "ORDER BY username ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}		

//added by ling: 2013-11-13
	
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
	
	
	
?>