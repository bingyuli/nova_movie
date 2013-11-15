<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>


<?php $layout_context = "admin"; ?>
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
  <h2><br></br>Administrator Sign In </h2>
  <form action="admin_dashboard.php" method= "post">
	<p><br></br>Email <br></br>
      <input type="text" name="username" value="" />
    </p>

    <p>Password <br></br>
       <input type="password" name="password" value="" />
    </p>
	
     	<button type ="submit"  class="blue" >
            Continue   
        </button>	       
  </form>   

  <br></br>
  <a href="index.php">Cancel</a>
  </div>
</div>
 <?php include("../includes/layouts/footer.php"); ?>