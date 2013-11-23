<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php
	$next_month = mktime(0,0,0,date("m")+1,date("d"),date("Y"));
	$next_month_date = date("Y-m-d", $next_month); 
	//update expr_date and expired
	$query  = "UPDATE user SET ";
	$query .= "expired = 0, ";
	$query .= "expr_date = '{$next_month_date}' ";
	$query .= "WHERE id ={$_SESSION["user_id"]}; ";
	$result = mysqli_query($connection, $query);
	confirm_query($result);
	redirect_to("user_dashboard.php");
	
	//update
	
?>

