 <!DOCTYPE html>
 <html>
 <?php
 		// Have to include this as first line of each page that 
		// you want to use session
		session_start();
		
	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
		
		//get id of current artwork
		$query = "SELECT *
				FROM Artist, Artwork, Terms
				WHERE Artist.artwork_id = Artwork_id
				AND Artwork_id = ?"
		
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
    		
	        

	  	        <form class="form-horizontal well">
	  	          <fieldset>
	  	            <legend>Please complete all the fields below</legend>
	         
				
	  			 <!-- Generate a dropdown menu of artist from the database-->

	  			     <div class="control-group">
	  			            <label class="control-label" for="select01">Select Artist</label>
	  			            <div class="controls">
							
	  			              <select id="select01" name ="artist_name">
							  
	  			 				 <?php 
	  			 				//get all artists for the dropdown
	  			 				// connect and get $con object
	  			 				include("mysql_connect.php");

	  			 				// Prepare query: What are artists first and last names in order by last name?
	  			 				$stmt = mysqli_prepare($con, "SELECT DISTINCT last, first FROM Artist ORDER BY Artist.last ASC");

	  			 				mysqli_stmt_execute($stmt);

	  			 				mysqli_stmt_bind_result($stmt, $name, $first);
	  			 				?>
	  	  						  <?php
	  	  			 			  while (mysqli_stmt_fetch($stmt)) {
	  	  							  ?>
								  
	  			                <option value="<?= $Artist_last ?>, <?= $Artist_first ?>"><?= $name ?>, <?= $first ?></option>
							
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
			              <input type="text" class="input-xlarge" id="input01">
			            </div>
			          </div>	
				
	  	        <!-- Artwork Date-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Date</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01">
					  	</div>
			          </div>
				
				<!-- Medium-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Medium</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01">
					  	</div>
			          </div>
				
				<!-- Credit Line-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Credit Line</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01">
			            </div>
			          </div>
				
				<!-- AccessionNum-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Accession Number</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01">
			            </div>
			          </div>
				
				<!-- Upload Image-->	
	           
			    <div class="control-group">
			              <label class="control-label" for="fileInput">Upload Image</label>
			              <div class="controls">
			                <input class="input-file" id="fileInput" type="file">
			              </div>
			            </div>


	  	   <!-- generate the checkboxes for nationalities from the database-->					
	  	<div class="control-group">
	  	<label class="control-label" for="optionsCheckbox">Artwork Terms</label>
	
	  		<?php 
	  		//get all nationalities for the dropdown
	  		// connect and get $con object
	  		include("mysql_connect.php");
	
	  		// Prepare query: What terms are included? 
	  		$stmt = mysqli_prepare($con, "SELECT DISTINCT term_name FROM Terms ORDER BY Terms.term_name ASC");
	
	  		mysqli_stmt_execute($stmt);
	
	  		mysqli_stmt_bind_result($stmt, $term);
	  		?>
		
	  		<div class="controls">

	      		<?php
	     	 		while (mysqli_stmt_fetch($stmt)) {
	      			?>		 
	               
	  					<label class="checkbox">
	  	                  <input id="optionsCheckbox" value="option1" type="checkbox">
	  	                  <?= $term ?> 
	  	                </label>
	  
	     				<?php
	     	 		}


	     	 	mysqli_stmt_close($stmt);


	      	?>
	  		</div>
	  	</div>
          

				
				
				
	  	            <div class="form-actions">
					
	  	              <a button type="submit" class="btn btn-primary" href="edit_results">Submit</a>
	  	              <button type="reset" class="btn">Cancel</button>
					  
	  	            </div>
					
	  	          </fieldset>
	  	        </form>
    
	  		</div>
	  	</div>	   <!-- row -->
	  	</div> 	   <!-- container-->

</body>
</html>
