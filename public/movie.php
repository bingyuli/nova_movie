

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>

  function shpwMovie () {
    //alert("aaaaaa");
	var d;
	$.get( "fetchMovie.php", { name: "John" }, function( data ) {
	  d = data;
	  var html = '';
	  for(var i = 0; i < d.length; i++)
            html += '<tr><td>' + d[i].name + '</td><td>' + d[i].year + '</td><td>' 
			+ d[i].director + '</td><td>' + d[i].rating + '</td><td>' + d[i].introduction + "</td></tr>";
	$('#movieTable tr').first().after(html);
    },"json");

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
  <div id = "1ab"></div>
  
</div>
<body>
  <table border="1" id = "movieTable">
	<tr>
	<th>Title</th>
	<th>Year</th>
	<th>Director</th>
	<th>Rating</th>
	<th>Introduction</th>
	</tr>
  </table> 


</body>