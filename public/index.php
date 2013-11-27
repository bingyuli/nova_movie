<!--<?php include("../includes/layouts/header.php"); ?> -->
<?php 
	if (!isset($layout_context)) {
		$layout_context = "public";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Nova Movie - Watch Movies Online</title>
		<link href="stylesheets/public.css" media="all" rel="stylesheet" type="text/css" />
		<style>
		body {background-image:url('image/background.jpg');}
		</style>
	</head>
	
	<body>
    <div id="header">
      <h1>Nova Movie <?php if ($layout_context == "admin") { echo "Admin"; } ?></h1>
	
	
		<div class="hlinks">
		    <a href="user_login.php"><span class="text">Member Sign In</span></a>
		</div>

		<div class="hlinks">
		    <a href="admin_login.php"><span class="text">Administrator Sign In</span></a>
		</div>
	  	</div>
  
  <div id="main">
	
		
      <div id="navigation">
        &nbsp;
      </div>
      <div id="page">
        <h5>
			<br> </br>
			<br> </br>
			<br> </br>
			<br> </br>
			<br> </br><font size="6" color="white";>
			Watch movies anytime, anywhere.
			<br> </br>
			<br> </br>
			Only $10.99 a month.
			<br> </br></font>
			<br> </br>
			
		</h5>
		<form action="new_user.php" method= "LINK">
      	<button type ="submit"  class="blue" >
		    Start Your Free Month
			

		</button>		       
		</form>
    
    </div>
    
<?php include("../includes/layouts/footer.php"); ?>