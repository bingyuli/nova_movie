<?php require_once("../includes/db_connection.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

	
	
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
        <h2>
			<br> </br>
			<br> </br>
			Watch movies anytime, anywhere.
			<br> </br>
			<br> </br>
			Only $10.99 a month.
			<br> </br>
			<br> </br>
			
		</h2>
		<form action="new_user.php" method= "LINK">
      	<button type ="submit"  class="blue" >
		    Start Your Free Month
			

		</button>		       
		</form>
    
    </div>
    
<?php include("../includes/layouts/footer.php"); ?>