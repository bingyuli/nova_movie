<?php include("../includes/layouts/header.php"); ?>
  
<div class="hlinks">
   <a href="index.php"><span class="text">Sign Out</span></a>
</div>

</div>

<div id="main">
     <div id="navigation">
        &nbsp;
     </div>

    <div id="page">	
	  <h1><br></br>Start your free month! </h1>
   	  <h2><br></br>Your free month ends on ?? </h2>
	    
	  <form action="new_dashboard.php" method="post">
      <p><br></br>Your first name <br></br>
        <input type="text" name="firstname" value="" />
		     <br></br>Your last name <br></br>
	    <input type="text" name="lasttname" value="" />
      </p>

	  <p><br></br>Your payment information <br></br>
        <input type="text" name="payment" value="" />		    
      </p>

	  <button type ="submit"  class="blue" >
		   Submit
		</button>     
    </form>
    <br />
    <a href="index.php">Cancel</a>
  </div>	
       
	  
</div>
<?php include("../includes/layouts/footer.php"); ?>