

<script src="../includes/jquer.js"></script>
<script>

  function shpwMovie () {
    alert("aaaaaa");
	
    var id = document.getElementById("movieID");
    //var idArr = new Array(categoryEN,brandEN);
	  $.post("fetchMovie.php", {arr : id},function(data) {
	   //showPic(data);
	   alert(data);
      }, 
	  "json");
	
  }
  
</script>

<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="manage_actors.php"><span class="text">Back</span></a>
</div>
<div>
  <p>movie ID <br></br>
       <input type="text" id="movieID" value="" />
	   <input type="button" onclick="shpwMovie()" value="show movie"/>
  </p>

</div>