<!DOCTYPE html>
 <html>
 <?php
 		// Have to include this as first line of each page that 
		// you want to use session
		session_start();

	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
		
		
		 

	    
	    //Check to see if we're performing any actions.
    if (isset($_GET['action'])) {
        if ($_GET['action'] == "delete") {
        
            $stmt = mysqli_prepare($con, "DELETE FROM Artwork WHERE Artwork.id=?");
            mysqli_stmt_bind_param($stmt, 'i', $_GET['id']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $message = "Record deleted successfully.";
        }?>
    <div class= "container"r>
    
    <div class="row-fluid">
    <div class="span10">
        <div class="alert alert-block">
          <a class="close">&times;</a>
          <h4 class="alert-heading">Delete Notice</h4>
          <p>The entry has been successfully deleted.</p>
        </div>
    </div>   
    </div>
    
    <?php }//if actions 
   
    ?>
    
    <head>
    <title>Blanton Museum of Art Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrapSpacelab.css" rel="stylesheet" media="screen">
    </head>
	<body>
		<div class= "container"r>
			<div class="row-fluid">
				<div class="span12">
					<div class="page-header">
					  <h2>Artwork Database 
						  	
							  <a class="btn btn-info btn-large pull-right" href="newentry.php">New Entry</a>
							  <a class="btn btn-info btn-large pull-right margin=25px" href="newartist.php">New Artist</a>
					  	  	 
				  	</h2>
					
				  </div>
					
				
	  	          <!-- PHP GOES HERE AND INTO THE TABLE. I USED DUMMY TEXT, FORMATTING SHOULD WORK -->
				  <?php
				  
				 
				  
				  $query = "SELECT Artwork.id, Artist.last, Artist.first, Artwork.title, Artwork.date, Artwork.medium, Artwork.accessionnum, Terms.term_name
							FROM Artist, Artwork, Terms
							WHERE Artist.id = Artwork.artist_id
							AND Terms.id = Artwork.term_id
							ORDER BY Artist.last"
							; //query for edit and delete table
							
					$stmt = mysqli_prepare($con, $query);
					
					mysqli_stmt_execute($stmt);
					mysqli_stmt_bind_result($stmt, $Artwork_id, $Artist_last, $Artist_first, $Artwork_title, $Artwork_date, $Artwork_medium, $Artwork_accessionnum, $Term_name);
			  
			
				?>
				  <table class='table table-bordered table-striped table-hover'>
				    <thead>
				      <tr>
				        <th>id</th>
				        <th>Last Name</th>
				        <th>First Name</th>
						<th>Artwork</th>
						<th>Date</th>
						<th>Medium</th>
						<th>Accession</th>
						<th>Term</th>
						<th> </th>
						<th> </th>
				      </tr>
				    </thead> 
					
					 <?php
					 while(mysqli_stmt_fetch($stmt)) { //displays data table
					 ?>
				    <tbody>
				      <tr>
  				        <td><?= $Artwork_id; ?></td>
  				        <td><?= $Artist_last; ?></td>
  				        <td><?= $Artist_first; ?></td>
  						<td><?= $Artwork_title; ?></td>
  						<td><?= $Artwork_date; ?></td>
  						<td><?= $Artwork_medium; ?></td>
  						<td><?= $Artwork_accessionnum; ?></td>
						<td><?= $Term_name; ?></td>
						<td>
						<a class='btn btn-primary btn-small' href='editentry_jm.php?Artwork_id=<?= $Artwork_id; ?>' title="Edit Record">Edit</a></td>
						<td><a class='btn btn-danger btn-small' href='admin.php?action=delete&id=<?= $Artwork_id; ?>'>Delete</a></td>
				      </tr>
				    </tbody>
					<?php } ; 
					
					print "</table>";
					mysqli_stmt_close($stmt);
					?>
				
					   <!-- PHP GOES HERE -->

				</div>
			</div>
		</div>


</body>
</html>

