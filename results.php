 <!DOCTYPE html>
 <html>
 
 <?php

	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli connection $con
		
	?>
	
    <head>
    <title>Blanton Museum of Art Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrapSpacelab.css" rel="stylesheet" media="screen">
    </head>
	<body>
		<div class= "container">
			<div class="row-fluid">
				<div class="span12">
					<div class="page-header">
					  <h2>Search Results
					  <a class="btn btn-inverse btn-large pull-right" href="index.php">Back</a>
					  </h2>
				  </div>
				  
		  		<!-- Prepare query: Select all the fields for the table, based on the fields from the search page. -->
		  		<!-- Use wildcard defaults if nothing is selected -->
		
		  		<?php 

		  		$query = "SELECT Artwork.thumbnail, Artist.first, Artist.last, Artwork.title, Artwork.date, Artwork.medium, Artwork.credit, Artist.nationality,  Artist.birth, Artist.death, Terms.term_name, Artist.id FROM Artist, Artwork, Terms WHERE 		   Artwork.artist_id=Artist.id AND Artwork.term_id = Terms.id AND Artist.last LIKE ? AND Artwork.date >= ? AND Artwork.date <= ? AND Artist.nationality LIKE ? AND Terms.term_name LIKE ? ORDER BY Artist.last ASC ";
		
		  		$stmt = mysqli_prepare($con, $query);	
		  		mysqli_stmt_bind_param($stmt, "siiss", $_GET["artist_id"], $_GET["fromdate"], $_GET["todate"], $_GET["nation"], $_GET["terms"]);
		
		  		mysqli_stmt_execute($stmt);
		
		  		mysqli_stmt_bind_result($stmt, $img, $first, $last, $title, $date, $medium, $credit, $nation, $birth, $death, $term, $id);
		  		?>
		
		

				
	  	          <!-- TABLE HEAD -->
			  
				  <table class="table table-bordered table-striped table-hover">
				    <thead>
				      <tr>
				        <th>Image</th>
				        <th>Last Name</th>
				        <th>First Name</th>
						<th>Title</th>
						<th>Date</th>
						<th>Medium</th>
						<th>Credit</th>
						<th>Nationality</th>
						<th>Keyword</th>
						<th>Detail</th>
				      </tr>
				    </thead>
					
					<!-- TABLE BODY WITH PHP fetch for the results table -->
				    
				      
					 <tbody>
 				        <?php

 				        //Loop through the records and make a table row for each.

 				        while (mysqli_stmt_fetch($stmt)) {
 				        ?>	
						<tr> 
	  				       <td><img src="<?= $img; ?> " alt-"Database Image" title="Artwork Image"/></td>
	  				        <td><?= $last; ?></td>
	  				        <td><?= $first; ?></td>
	  						<td><?= $title; ?> </td>
	  						<td><?= $date; ?></td>
	  						<td><?= $medium; ?></td>
	  						<td><?= $credit; ?></td>
							<td><?= $nation; ?> </td>
							<td><?= $term; ?></td>
							<form action="artwork.php" method="GET"> 
							<input type="hidden" name="artist_page" value="<?= $id; ?>">
							<td><input type="submit" value="Submit" class="btn btn-success btn-small"/></td> </form>
							
					    </tr>
					</tbody>

				        <?php
				        }//end the while

				        mysqli_stmt_close($stmt);
				        
				        ?>
				
				    
				  </table>
			
						  

				</div>
			</div>
		</div>


</body>
</html>

