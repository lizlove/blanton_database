 <!DOCTYPE html>
 <html>
<!--<pre>
 <?php print_r($_POST) ?>
 </pre>-->

 <?php
		// Have to include this as first line of each page that 
		// you want to use session
		session_start();
		
		
		
	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
	    
	   
	    
	    //Check if the form has already been submitted. If so, create the record.
	    if (isset($_POST['submitted'])) {
	    
	    //identifies that path of the image file to enter into the thumbnail attribute
        $full_path_to_image = "img/" . $_FILES["thumbnail"]["name"];
        
        $stmt = mysqli_prepare($con, "INSERT INTO Artwork (title, date, medium, credit, accessionnum, thumbnail, artist_id, term_id) VALUES (?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sissssii', $_POST['title'], $_POST['date'], $_POST['medium'], $_POST['credit'], $_POST['accessionnum'], $full_path_to_image, $_POST['artist_id'], $_POST['term_id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
		$message = "New artwork added. Do you have another to add?";
		

        
        //this section has the script to upload an image and save it to the img folder in the database. 	

 	    if ($_FILES["thumbnail"]["error"] > 0)
    	  {
   			echo "Return Code: " . $_FILES["thumbnail"]["error"] . "<br>";
   		  }
 	   // else
   	   //  {
   	   //	echo "Upload: " . $_FILES["thumbnail"]["name"] . "<br>";
   	   //	echo "Type: " . $_FILES["thumbnail"]["type"] . "<br>";
  	   //	echo "Size: " . ($_FILES["thumbnail"]["size"] / 1024) . " kB<br>";
   	   //	echo "Temp file: " . $_FILES["thumbnail"]["tmp_name"] . "<br>";
   		
   		
   		//moves and saves file to the img folder
   		
    
    	if (file_exists("img/" . $_FILES["thumbnail"]["name"]))
      	  {
      		echo $_FILES["thumbnail"]["name"] . " already exists. ";
      	   }
    	else
      	{
      	move_uploaded_file($_FILES["thumbnail"]["tmp_name"],
      	"img/" . $_FILES["thumbnail"]["name"]);
      //echo "Stored in: " . "img/" . $_FILES["thumbnail"]["name"];
      	  }
    	}

	  // }//if submitted
	
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
	  		<div class="span12">
	  			<div class="page-header">
	  			  <h2>New Entry
	  			  <a class="btn btn-inverse btn-large pull-right" href="admin.php">Back</a>
	  			  </h2>
	  			  </div>
    <?php
		if (isset($message) && $message != "") {
		?>
		<div class="alert alert-success">
			<strong><?= $message; ?></strong>
		</div>
		<?php
			}	
	?>   

	  	        <form class="form-horizontal well" action="#" method="post" enctype="multipart/form-data">
	  	          <fieldset>
	  	            <legend>Please complete all the fields below</legend>
	         
				
	<!-- Generate a dropdown menu of artist from the database -->

	  			     <div class="control-group">
	  			            <label class="control-label" for="select01">Select Artist</label>
	  			            <div class="controls">
	  			              <select id="select01" name="artist_id">
	  			 				 <?php 
	  			 				//get all artists for the dropdown
	  			 				// connect and get $con object
	  			 				include("mysql_connect.php");

	  			 				// Prepare query: What are artists first and last names in order by last name?
	  			 				$stmt = mysqli_prepare($con, "SELECT DISTINCT last, first, id FROM Artist ORDER BY Artist.last ASC");

	  			 				mysqli_stmt_execute($stmt);

	  			 				mysqli_stmt_bind_result($stmt, $name, $first, $id);
	  			 				?>
	  	  						  <?php
	  	  			 			  while (mysqli_stmt_fetch($stmt)) {
	  	  							  ?>
								  
	  			                <option value="<?= $id ?>"><?= $name ?>, <?= $first ?></option>
							
	  									<?php
	  						 		}
	  								mysqli_stmt_close($stmt);
	  								?>
							
	  			              </select>
	  			            </div>
	  			          </div>
	
				
				<!-- Artwork Title-->
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Title</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="title">
			            </div>
			          </div>	
				
	  	        <!-- Artwork Date-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Date</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="date">
					  	</div>
			          </div>
				
				<!-- Medium-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Medium</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="medium">
					  	</div>
			          </div>
				
				<!-- Credit Line-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Credit Line</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="credit">
			            </div>
			          </div>
				
				<!-- AccessionNum-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Accession Number</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="accessionnum">
			            </div>
			          </div>
				
<!-- Upload Image	-->
	           
			    <div class="control-group">
			              <label class="control-label" for="file">Upload Image</label>
			              <div class="controls">
			                <input class="input-file" id="file" type="file" name="thumbnail">
			              </div>
			            </div>
			            



<!-- generate the radio buttons for terms from the database	-->				
	  	<div class="control-group">
	  	<label class="control-label" for="optionsRadio">Artwork Terms</label>
	
	  		<?php 
	  		//get all terms for the dropdown
	  		// connect and get $con object
	  		include("mysql_connect.php");
	
	  		// Prepare query: What terms are included? 
	  		$stmt = mysqli_prepare($con, "SELECT DISTINCT term_name, id FROM Terms ORDER BY Terms.term_name ASC");
	
	  		mysqli_stmt_execute($stmt);
	
	  		mysqli_stmt_bind_result($stmt, $term, $id);
	  		?>
		
	  		<div class="controls">

	      		<?php
	     	 		while (mysqli_stmt_fetch($stmt)) {
	      			?>		 
	               
	  					<label class="radio">
	  	                  <input id="optionsRadio" value="<?= $id ?>" type="radio" name="term_id">
	  	                  <?= $term ?>
	  	                </label>
	  
	     				<?php
	     	 		}


	     	 	mysqli_stmt_close($stmt);


	      	?>
	  		</div>
	  	</div>
	  	
	  	            <div class="form-actions">
	  	              <input type="hidden" name="submitted" value="true"/>
	  	              <button type="submit" class="btn btn-primary">Submit</button>
	  	              <button type="reset" class="btn">Cancel</button>
	  	            </div>
	  	          </fieldset>
	  	        </form>
    
	  		</div>
	  	</div>	   <!-- row -->
	  	</div> 	   <!-- container-->

</body>
</html>
