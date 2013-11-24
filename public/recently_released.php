<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

	  	</div>
  
  <div id="main">
	<div class="wrapper">
		
      <div id="navigation">
		<br />
		<a href="user_dashboard.php">&laquo; User Dashboard Home</a><br />
        &nbsp

      </div>
      <div id="page">
	  
		<h1>Recently Released Movie</h1>
		<table align="left" cellpadding="1">
			<?php
				global $connection;
			
			if (mysqli_connect_errno())
				{
					echo "Failed to connect to mysqli: ".mysqlii_connect_error();
				}
			
			$query1 ="select MAX(id) as max from movie";
			$result1 = mysqli_query($connection, $query1); 
			$row = mysqli_fetch_assoc($result1);
			
			$query2 ="select id, name, year, picture, ave_star, introduction from movie where id>".$row['max']."-5 and year>'2012'";
			$result2 = mysqli_query($connection, $query2);
			
			while ( $movie = mysqli_fetch_assoc($result2))
			{
				echo "<tr>";
				echo	"<td width=\"110px\"><img src='".$movie['picture']."' width=\"110px\" height=\"150px\"/></td>";
				echo	"<td width=\"500px\">";
				echo		"<ul>";
				echo		"<h3><a href=\"movie.php?movieId={$movie['id']}\"> ".$movie['name']."</a></h3>";
				echo		"<li><strong>Average Star:&nbsp</strong> ".$movie['ave_star']."</li>";
				echo		"<li><strong>Actor:&nbsp</strong>";

				$query3 = "select name from actor where id in (select actor_id from cast where movie_id=".$movie['id'].")";
				$result3 = mysqli_query($connection, $query3);
				$num = mysqli_num_rows($result3);

				while ($actor = mysqli_fetch_assoc($result3))
				{		
					echo "".$actor['name']."";
					if ( $num-1 >0 )
						{
							echo ",&nbsp";
							$num--;
						}
				}
				echo "</li>";
				echo "<li><strong>Genre:&nbsp</strong>";
				
				$query4 = "select type from genre where movie_id = ".$movie['id']."";
				$result4= mysqli_query($connection, $query4);
				$num = mysqli_num_rows($result4);

				while ( $genre = mysqli_fetch_assoc($result4))
				{
					echo "".$genre['type']."";
					if ( $num-1 >0 )
						{
							echo ",&nbsp";
							$num--;
						}
				}
				echo "</li>";
				echo "<li><strong>Year:&nbsp</strong>".$movie['year']."</li>";
				echo "<li><strong>Description:&nbsp</strong>".$movie['introduction']."</li>";
				echo "<li align=\"right\"><strong>Detail</strong></li>";
				echo "</tr>";
			}
			?>
		</table>
    </div>
    </div>
    
<?php include("../includes/layouts/footer.php"); ?>