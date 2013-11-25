<?php
  session_start();
  
  // check for user log-in
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $userId = $_SESSION['user_id'];
  } else {
	$url = 'http://localhost/nova_movie/public/user_login.php';	
    //header("Location: $url");
  }
  //echo $_SESSION['user_id'];    
 
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
  $query = "select movie_id, name, year from movie,watched where movie_id = movie.id and user_id=" .$userId;
  $query .= " ORDER BY watched.id DESC";  
		
  $result = mysqli_query($connection, $query);	
  $arr = array();
  while (($movie = mysqli_fetch_assoc($result)) != null) {
    array_push($arr, $movie);
  };	
  
  echo json_encode($arr);
  
?>
