<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	// v1: simple logout
	// session_start();
	$_SESSION["user_id"] = null;
	$_SESSION["user_name"] = null;
	$_SESSION["user_email"] = null;
	$_SESSION["message"] =null;
	redirect_to("index.php");
?>
<?php
	// v2: destroy session
	// assumes nothing else in session to keep
	// session_start();
	// $_SESSION = array();
	// if (isset($_COOKIE[session_name()])) {
	//   setcookie(session_name(), '', time()-42000, '/');
	// }
	// session_destroy(); 
	// redirect_to("player_login.php");
?>
