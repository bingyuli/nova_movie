<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php include("../includes/layouts/header.php"); ?>

    
 <div class="hlinks">
   <a href="index.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  
  <div id="page">

  
    <h1><br></br>Ready to start your free month? </h1>

    <h2><br></br>Create your account:</h2>
    <form action="new_user_infor.php" method="post">
	
      <p><br></br>Email Address <br></br>
        <input type="text" name="username" value="" />
      </p>

      <p>Choose a password (4-20 characters)<br></br>
        <input type="password" name="password" value="" />
      </p>

		<button type ="submit"  class="blue" >
		   Register
		</button>     
    </form>
    <br></br>
    <a href="index.php">Cancel</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php"); ?>