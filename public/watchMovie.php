<?php
    session_start();
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

  $userId; 
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userId =  $_SESSION['userID'];
  } 
  
  
   //$id = $_GET['movieId'];
  $movieId = 1;
  $query = "insert into watched(user_id,movie_id) values(" .$userId.$id. ")";
  $result = mysqli_query($connection, $query);	
  
?>