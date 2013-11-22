<?php
  session_start();
  
  // check for user log-in
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    //echo $_SESSION['userID'];
  } else {
	$url = 'http://localhost/public/user_login.php';	
    //header("Location: $url");
  }
  //echo $_SESSION['userID'];
?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>

  // show all movies
  function showAllMovie () {
	$.get( "fetchMovie.php", { name: "John" }, function( d ) {
	  var html = '';
	  for(var i = 0; i < d.length; i++)
            html += "<tr><td id="+ d[i].id +" onClick='addToIn(this)'><font color='red'>Save</font></td><td>" 
			+ d[i].name + '</td><td>' + d[i].year + '</td><td>' + d[i].director + '</td><td>' + d[i].rating + '</td><td>' 
			+ d[i].introduction + "</td><td id="+ d[i].id +" onClick='addToIn(this)'>Watch this</td></tr>";
	$('#movieTable tr').first().after(html);
    },"json");

  }
  
  // add to interested or watched table
  function addToIn() {
    //..alert(movie.id);
	$.get( "fetchMovie.php", { movieId: 1,aol: 2 }, function( data ) {
	  alert(data)
	});
  }
  
  // show current user's interested or watched movie list
  function showInterested(movie) {
    //..alert(movie.id);
	$.get( "fetchMovie.php", { movieId: movie.id }, function( data ) {
	  alert(movie.id)
	});
  }
  
</script>

<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="manage_actors.php"><span class="text">Back</span></a>
</div>
<div>
  <p>movie ID <br></br>
	   <input type="button" onclick="showAllMovie()" value="show all movies"/>
	   <input type="button" onclick="addToIn()" value="show interested movies"/>
  </p>
  
</div>
<body>
  <table border="1" id = "movieTable">
	<tr>
	<td>SaveToInterest</td>
	<th>Title</th>
	<th>Year</th>
	<th>Director</th>
	<th>Rating</th>
	<th>Introduction</th>
	<td></td>
	</tr>
  </table> 

</body>