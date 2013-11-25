<?php
  session_start();
?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script >
/*
 $( document ).ready(function() {
$( "p" ).text( "The DOM is now loaded and can be manipulated." );
});
*/
$( document ).ready(function() {
  $.get( "interest.php", function( data ) {
	  //alert(data[0])
	  
	  var html = '';
		
	  for(var i = 0; i < data.length; i++)
	    html += "<tr><td><a href=movie.php?movieId=" + data[i].movie_id + ">" 
		+ data[i].name + "</a></td><td>"  +  data[i].year  + "</td></tr>";
	  
	$('#movieTable tr').first().after(html);  
	},"json");
	
});

</script>

<!--
<div>	
	<a href= "movie.php?movieId=<?php //echo data[i].movie_id; ?>" > <?php //echo data[i].name; ?></a>	
</div>
-->

<?php require_once("../includes/layouts/header.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<div class="hlinks">
   <a href="user_dashboard.php"><span class="text">Back</span></a>
</div>

<div id="main">
<div id="navigation">
	  &nbsp;
</div>

<div id="page">
	<h3> Interested List of <?php echo htmlentities($_SESSION["user_name"]); ?></h3>			
	<br>
  <table border="1" id = "movieTable">
	<tr>
	<th>Title</th> 
	<th>Year</th>
	</tr>
</table>
</div>

<?php include("../includes/layouts/footer.php"); ?>