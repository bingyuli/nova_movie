<?php require_once("../includes/session.php"); ?>

<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
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
  //$id = $_POST['movieID'];
  $id = 1;
  $query = "select name,year,director,rating,introduction from movie"; // where id =  .$id;  
  $result = mysqli_query($connection, $query);	

  $arr = array();
  while (($movie = mysqli_fetch_assoc($result)) != null) {
    array_push($arr, $movie);
  };
  echo json_encode($arr);
?>