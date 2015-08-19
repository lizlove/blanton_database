 <!DOCTYPE html>
 <html>
 <?php
 		// Have to include this as first line of each page that 
		// you want to use session
		session_start();
		
	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
		
					//Check whether entry has already been updated
					if (isset($_POST['submitted'])) {
					 $full_path_to_image = "img/" . $_FILES["image"]["name"];
						$stmt = mysqli_prepare($con, "UPDATE Artist, Artwork, Terms
										SET Artist.last=?, Artist.first=?, Artwork.title=?, Artwork.date=?,
											Artwork.medium=?, Artwork.credit=?, Artwork.thumbnail=?,
											Artwork.accessionnum=?, Artist.nationality=?, Terms.term_name=?, Artwork_thumbnail=?
										WHERE Artist.id = Artwork.artist_id
										AND Terms.id = Artwork.term_id
										AND Artwork.id=?");
						mysqli_stmt_bind_param($stmt, 'sssisssssssi', $_POST['last'], $_POST['first'], $_POST['title'], $_POST['date'],
											$_POST['medium'], $_POST['credit'], $_POST['image'], $_POST['accessionnum'],
											$_POST['nationality'], $_POST['term'], $_POST['Artwork_id'], $full_path_to_image);
            
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt); 
			
			 
						//Checks to see if new image was added
						$stmt1 = mysqli_prepare($con, "INSERT INTO Artwork (thumbnail) VALUES (?)");
						mysqli_stmt_bind_param($stmt1, 's', $full_path_to_image);
						mysqli_stmt_execute($stmt1);
						mysqli_stmt_close($stmt1);
			
	
			$message = "Entry updated successfully";}
			

		
		
			//Generates artwork entry table
		$query = "SELECT Artwork.id, Artist.last, Artist.first, Artwork.title, 
						Artwork.date, Artwork.medium, Artwork.accessionnum, Terms.term_name, 
						Artwork.credit, Artwork.thumbnail, Artist.nationality
				FROM Artist, Artwork, Terms
				WHERE Artist.id = Artwork.artist_id
				AND Terms.id = Artwork.term_id
				AND Artwork.id=?";
		$stmt = mysqli_prepare($con,$query);
		mysqli_stmt_bind_param($stmt,'i',$_GET['Artwork_id']);
		mysqli_stmt_bind_result($stmt, $Artwork_id, $last, $first, $title,
								$date, $medium, $accessionnum, $term, $credit, $img, $nat);
		mysqli_stmt_execute($stmt);

				
				
		

		
	?>
    <head>
    <title>Blanton Museum of Art Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrapSpacelab.css" rel="stylesheet" media="screen">
    </head>
	<body>
	    <div class="container">
	  	<div class="row-fluid">
	  		<div class="span10">
	  			<div class="page-header">
	  			  <h2>Edit Entry</h2>
	  			  </div>
    		
	        

	  	        <form class="form-horizontal well" action="edit_results.php?id=<?= $Artwork_id ?>" method="POST" enctype="multipart/form-data" >
	  	          <fieldset>
	  	            <legend>Please complete all the fields below</legend>
	         
				
	  			 <!-- Generate a text field to edit artist name-->
				 

	  			     <div class="control-group">
					 <?php while (mysqli_stmt_fetch($stmt)) { ?> 
	  			            <label class="control-label" for="select01">Name</label>
	  			            <div class="controls">
							
	  			             
	  			                 <input type="text" class="input-medium" id="input01" name="first" 
									value="<?= $first; ?>"> 
								<input type="text" class="input-medium" id="input01" name="last" 
									value="<?= $last; ?>">  
									
							
						
					
	  			            </div>
	  			          </div>
				
				
				<!-- Artwork Title-->
				
			    <div class="control-group">
				
			            <label class="control-label" for="input01">Title</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" name="title"
							value="<?= $title; ?>">
						  
						  
			            </div>
			          </div>	
				
	  	        <!-- Artwork Date-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Date</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" name="date"
							value="<?= $date ?>">
					  	</div>
			          </div>
				
				<!-- Medium-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Medium</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" name="medium"
							value="<?= $medium ?>">
					  	</div>
			          </div>
				
				<!-- Credit Line-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Credit Line</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" name="credit"
							value="<?= $credit ?>">
			            </div>
			          </div>
				
				<!-- AccessionNum-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Accession Number</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" name="accessionnum"
							value="<?= $accessionnum ?>">
			            </div>
			          </div>
				
				<!-- Upload Image-->	
	           
			    <div class="control-group">
			              <label class="control-label" for="image">Upload Image</label>
			              <div class="controls">
						  <img src="<?= $img; ?> " alt-"Database Image" title="images" />
			                <input class="input-file" type="file" name="image" />
							
			              </div>
			            </div>


	  	   <!-- generate the menu for nationalities from the database-->	
<?php
			include("mysql_connect.php");
			//Prepare query: Which nationalities will be listed?
		  $base_query1 = "SELECT DISTINCT nationality FROM Artist";
		   $stmt1 = mysqli_prepare($con, $base_query1);
		    //get all terms for dropdown menu
			// connect and get $con object
			mysqli_stmt_execute($stmt1);
			mysqli_stmt_bind_result($stmt1, $nation);
			?>
			
		<div class="control-group">
	  	<label class="control-label" for="input01">Artist Nationality</label>
			<div class="controls">
				<select name="nationality" value="<?= $nat ?>">
					<option name="<?= $nat ?>" selected>
						<?= $nat ?>
					</option>
					<?php while (mysqli_stmt_fetch($stmt1)) 
								{if($nat != $nation) {echo "<option>$nation</option>";}} 
								//Lists all nationalities without duplicating the preselected nationality
								?>
				</select>
			<?php mysqli_stmt_close($stmt1); ?>	
		</div>
		</div>
		
		
			  	   <!-- generate the menu for terms from the database-->
<?php 

	  		include("mysql_connect.php");
	
	  		// Prepare query: What terms are included? 
			$base_query2 = "SELECT DISTINCT term_name FROM Terms ORDER BY Terms.term_name ASC";
	  		$stmt2 = mysqli_prepare($con, $base_query2);
		  		//get all terms for the dropdown
				// connect and get $con object
	  		mysqli_stmt_execute($stmt2);
	
	  		mysqli_stmt_bind_result($stmt2, $terms);
	  		?>
		   
	  	<div class="control-group">
	  	<label class="control-label">Artwork Term</label>
			            <div class="controls">
			              <select name="term">
							<option name="<?= $term ?>" selected>
								<?= $term ?>
							</option>
							
								<?php while (mysqli_stmt_fetch($stmt2)) 
								{if($term != $terms) {echo "<option>$terms</option>";}} 
								//Lists all terms without duplicating the preselected term
								//that has already been assigned to the artwork
								?>
							
						  
						  </select>
						  	<input type="hidden" name="Artwork_id" value="<?= $Artwork_id; ?>" />
						<?php mysqli_stmt_close($stmt2); ?>
	     				
	     	 
	  		</div>
	  	</div>
          

			
				
				
	  	            <div class="form-actions">
								<!--Hidden submit button to check if form has been submitted -->
	  	              				<input type="hidden" name="submitted" value="true" />	
									<input type="submit" class="btn btn-info btn-medium" />
									
									<button type="reset" class="btn btn-medium">Reset</button></form>
									<form action="admin.php">
									<!--Cancel button returns user to admin page -->
									<button class="btn btn-danger btn-small pull-right">Cancel</button>
					  
					  <?php } ?>
					  
	  	            </div>
					
	  	          </fieldset>
	  	        </form>
    
	  		</div>
	  	</div>	   <!-- row -->
	  	</div> 	   <!-- container-->

</body>
</html>
