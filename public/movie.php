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
  // load all movie information when the page is ready
  var $_GET = {};
  var movieId;
  $( document ).ready(function() {
     if (document.location.toString().indexOf('?') != -1) {
		var query = document.location.toString().replace(/^.*?\?/,'').split('&');
		  for(var i=0,l=query.length;i<l;i++) {
			var aux = unescape(query[i]).split('=');
			$_GET[aux[0]] = aux[1];
		  }
	  }
	  movieId = $_GET['movieId'];
     
	// load and show movie information
    $.get("fetchMovie.php",{movieId:movieId}, function( data ) {
	  $('#mov').append("<img src='../public/image/" + data.picture +"'>");
	  $('#mov').append("<h2>"+ data.name +"</h2>");
	  $('#mov').append("<h3>Year: "+ data.year +"</h3>");
	  $('#mov').append("<h3>Director: "+ data.director +"</h3>");
	  $('#mov').append("<h3>Rating: "+ data.rating +"</h3>");
	  $('#mov').append("<h3>Introduction: "+ data.introduction +"</h3>");
	  $('#mov').append("<h3>Played Times: "+ data.count +"</h3>");
	},"json");

	// load and show actors
    $.get("fetchActor.php", {movieId:movieId}, function(data) {
	  var html = "<h3>Acotr: ";
	  for (var i = 0; i < data.length; i++) {
	    html += data[i].name +", ";
	  }
	  $('#actor').append(html+"</h3>");
	},"json");

	// load and show review
	$.get("fetchReview.php", {movieId:movieId,mode:'fetch'}, function(data) {
	  var html = "<h3>Review: ";
	  for (var i = 0; i < data.length; i++) {
	    html += data[i].star +" ";
	  }
	  $('#review').append(html+"</h3>");
	},"json");
	
	// load and show comments
	$.get("fetchComment.php", {movieId:movieId,mode:'fetch'}, function(data) {
	  var html = "<h3>Comment: </h3>";
	  for (var i = 0; i < data.length; i++) {
	    html += "<p>"+ data[i].comment +"</p>";
	  }
	  $('#comment').append(html);
	},"json");
  });
  
  // watch movie
  // add movie to wathched list, updating movie count
  function watchMovie() {
    $.get( "watchMovie.php", {movieId: movieId}, function( data ) {
	  $('#message').append("<h3><font color='red'>You Just Watched this movie</h3>");
	});
  } 
   
  
  // add to interest list
  function addToIn() {
	$.get( "addTointerest.php", {movieId: movieId, mode:'add'}, function( data ) {
	  $('#message').append("<h3><font color='red'>You have added this movie to your interest list</h3>");
	});
  }
    
  // remove from interest list
  function deleteFromIn() {
	$.get( "addTointerest.php", {movieId: movieId, mode:'remove'}, function( data ) {
	  $('#message').append("<h3><font color='red'>You have removed this movie from your interest list</h3>");
	});
  }
  
  // rate movie
  function rate() {
    var rating = document.getElementById('userRating').value;
	
    $.get( "fetchReview.php", {movieId: movieId, mode:'rate',star:rating}, function( data ) {
	  $('#message').append("<h3><font color='red'>Thank you for rating</h3>");
	});
  }	
	
  // add comment	
  function addComment() {
    var comment = document.getElementById('userComment').value;
	
    $.get( "fetchComment.php", {movieId: movieId, mode:'comment',comm:comment}, function( data ) {
	  $('#message').append("<h3><font color='red'>Thank you for your comment</h3>");
	});
  }	
	

</script>

<?php include("../includes/layouts/header.php"); ?>
<div class="hlinks">
   <a href="user_dashboard.php"><span class="text">Back</span></a>
</div>
</div>

<div id="main">
  <div id="navigation">
	  &nbsp;
  </div>


  <div id="message"></div>

  <div id='mov'>
  </div>
  <div id='actor'></div>
  <div id='review'></div>
  <div id='comment'></div>
 
  <table> 
  <tr>    
   <td style ="width: 250px;">
  <input type="button" onclick="watchMovie()" value="Watch" class ="blue"/></td>
  <td style ="width: 250px;">
  <input type="button" onclick="addToIn()" value="Add To Interest List" class ="blue"/></td>
   <td style ="width: 250px;">
  <input type="button" onclick="deleteFromIn()" value="Remove from Interest List" class ="blue"/></td>

   </tr>    
   </table> 
  <form>
    Rating: <input type="text" id="userRating"><br>
	<input type="button" onclick='rate()' value="Submit Rating" class ="blue">
  </form> 
  
  <form>
    Comment: <input type="text" id="userComment"><br>
	<input type="button" onclick='addComment()' value="Submit Comment" class ="blue">
  </form> 

  
</div>
<?php include("../includes/layouts/footer.php"); ?>