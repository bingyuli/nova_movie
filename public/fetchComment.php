<?php
  define("DB_SERVER", "localhost");
	define("DB_USER", "nova_team");
	define("DB_PASS", "sjsuteam3");
	define("DB_NAME", "nova_movie");

  // 1. Create a database connection
	$connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
	if(mysqli_connect_errno()) {
		die("Database connection failed: " . 
			mysqli_connect_error() . 
			" (" . mysqli_connect_errno() . ")"
    );
  }
  
  //$userId = 1; 
  $userId;
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userId =  $_SESSION['userID'];
  } 
  
  $id = $_GET['movieId'];
  $mode = $_GET['mode'];
  if ($mode == 'fetch') {  
    $query = "select comment from comment where movie_id=" .$id;
    $result = mysqli_query($connection, $query);	
    $arr = array();
    while (($star = mysqli_fetch_assoc($result)) != null) {
      array_push($arr, $star);
    }
	echo json_encode($arr);
  }else if ($mode = 'comm') {
    $comment = $_GET['comm'];
    $query = "insert into comment(user_id,movie_id,comment) values(".$id.','.$userId.",'".$comment."')";
    $result = mysqli_query($connection, $query);
	echo $query;
  }
?>