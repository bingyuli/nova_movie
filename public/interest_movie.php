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
	    html += "<tr><td>" +  data[i].name + "</td><td>"  +  data[i].year  + "</td><tr>";
		
	$('#movieTable tr').first().after(html);  
	},"json");
	
});

</script>

<?php include("../includes/layouts/header.php"); ?>

<div class="hlinks">
   <a href="user_dashboard.php"><span class="text">Back</span></a>
</div>

<div id="main">
<div id="navigation">
	  &nbsp;
</div>

<div id="page">
    <h2>  </h2>
	<h3> Interested List of <?php $userId; ?></h3>			
	<br>
  <table border="1" id = "movieTable">
	<tr>
	<th>Title</th>
	<th>Year</th>
	</tr>
</table>
</div>

<?php include("../includes/layouts/footer.php"); ?>