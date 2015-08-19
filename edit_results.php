 <!DOCTYPE html>
 <html>
 <?php
 		// Have to include this as first line of each page that 
		// you want to use session
		session_start();

	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
		
		
				
			if (isset($_POST['submitted'])) {
			$full_path_to_image = "img/" . $_FILES["image"]["name"];
		
            $stmt = mysqli_prepare($con, "UPDATE Artist, Artwork, Terms
										SET Artist.last=?, Artist.first=?, Artwork.title=?, Artwork.date=?,
											Artwork.medium=?, Artwork.credit=?, 
											Artwork.accessionnum=?, Artist.nationality=?, Terms.term_name=?, Artwork.thumbnail=?
										WHERE Artist.id = Artwork.artist_id
										AND Terms.id = Artwork.term_id
										AND Artwork.id=?");
            mysqli_stmt_bind_param($stmt, 'sssissssssi', $_POST['last'], $_POST['first'], $_POST['title'], $_POST['date'],
											$_POST['medium'], $_POST['credit'], $_POST['accessionnum'],
											$_POST['nationality'], $_POST['term'], $full_path_to_image, $_POST['Artwork_id']);
             mysqli_stmt_execute($stmt);
			 
			mysqli_stmt_close($stmt); 
			$message = "Entry updated successfully";
			   $stmt1 = mysqli_prepare($con, "INSERT INTO Artwork (thumbnail) VALUES (?)");
        mysqli_stmt_bind_param($stmt1, 's', $full_path_to_image);
		mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);
				
				
			
    }
			

				
				
				
				
				
				
			//	$file = $_FILES['image']['name'];

			//	$stmt2 = mysqli_prepare($con, "INSERT INTO Artwork (thumbnail) VALUES('$file')");
			//	mysqli_stmt_execute($stmt2);
				

		 
	//	   mysqli_stmt_close($stmt2);
            
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
				  
				  
				  		<?php
			if (isset($message) && $message != "") {
			?>

			<p><strong><?= $message; ?></strong></p>
			<?php
			} else { 
		print "UPDATE FAILED";}
		//check if form updated successfully
		?>
		</div>
		<a class="btn btn-info btn-large pull-right" href="admin.php">Go Back</a>
				  
	  			  </div>
    		</body>
			</html>