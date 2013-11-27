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
// Set autocommit to off
//mysqli_autocommit($connection,FALSE);
?>