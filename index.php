    <!DOCTYPE html>
    <html>
	<?php

	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
		

		
		

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
			  <h2>Search the collection</h2>
			  </div>
    		
	        

	        <form action="results.php" method="GET" class="form-horizontal well">
	          <fieldset>
	            <legend>Find artwork in the database using any of the search tools below.</legend>
	         
				
			 <!-- Generate a dropdown menu of artist from the database-->

			     <div class="control-group">
			            <label class="control-label" for="select01">Select Artist</label>
			            <div class="controls">
			              <select name="artist_id" >
							  <option name="artist_id" selected="selected" value="%"> All Artists </option>
			 				 <?php 
			 				//get all artists for the dropdown
			 				// connect and get $con object
			 				include("mysql_connect.php");

			 				// Prepare query: What are artists first and last names in order by last name?
			 				$stmt = mysqli_prepare($con, "SELECT DISTINCT last, first, id FROM Artist ORDER BY Artist.last ASC");

			 				mysqli_stmt_execute($stmt);

			 				mysqli_stmt_bind_result($stmt, $name, $first, $artist_id);
			 				?>
	  						  <?php
	  			 			  while (mysqli_stmt_fetch($stmt)) {
	  							  ?>
								  
			                <option name="artist_id" value= "<?=$name?>" ><?= $name ?>, <?= $first ?></option>
							
									<?php
						 		}
								mysqli_stmt_close($stmt);
								?>
							
			              </select>
			            </div>
			          </div>
				
				
				
				
	        <!-- From and To artwork dates-->	
	           
			    <div class="control-group">
					<p class="help-block">Select date parameters for the Artwork</p>
	              <label class="control-label" for="Select">From Date:</label>
	              <div class="controls">
	                <select name="fromdate">
					  <option name="fromdate" selected="selected" value="1000"> All Dates </option>
	                  <option name="fromdate"value="1900">1900 </option>
	                  <option name="fromdate"value="1910">1910 </option>
	                  <option name="fromdate"value="1920">1920 </option>
	                  <option name="fromdate"value="1930">1930 </option>
	                  <option name="fromdate"value="1940">1940 </option>
	                  <option name="fromdate"value="1950">1950 </option>
	                  <option name="fromdate"value="1960">1960 </option>
	                  <option name="fromdate"value="1970">1970 </option>
	                  <option name="fromdate"value="1980">1980 </option>
	                  <option name="fromdate"value="1990">1990 </option>
	                  <option name="fromdate"value="2000">2000 </option>
	                </select>
	              </div>
	            </div>
				<div class="control-group">
					<label class="control-label" for="Select">To Date:</label>
					<div class ="controls">
						<select name="todate">
						  <option name="todate" selected="selected" value="3000"> All Dates </option>
	  	                  <option name="todate"value="1910">1910 </option>
	  	                  <option name="todate"value="1920">1920 </option>
	  	                  <option name="todate"value="1930">1930 </option>
	  	                  <option name="todate"value="1940">1940 </option>
	  	                  <option name="todate"value="1950">1950 </option>
	  	                  <option name="todate"value="1960">1960 </option>
	  	                  <option name="todate"value="1970">1970 </option>
	  	                  <option name="todate"value="1980">1980 </option>
	  	                  <option name="todate"value="1990">1990 </option>
	  	                  <option name="todate"value="2000">2000 </option>
	  	                  <option name="todate"value="2010">2010 </option>
					  </select>
				  </div>
			  </div>


	   <!-- generate the checkboxes for nationalities from the database-->					
	<div class="control-group">
	<label class="control-label" for="optionsCheckbox">Artist Nationality</label>
	
		<?php 
		//get all nationalities for the checkboxes
		// connect and get $con object
		include("mysql_connect.php");
	
		// Prepare query: What artist nationalities are represented? 
		$stmt = mysqli_prepare($con, "SELECT DISTINCT nationality FROM Artist");
	
		mysqli_stmt_execute($stmt);
	
		mysqli_stmt_bind_result($stmt, $nationality);
		?>
		
		<div class="controls">
			
			   <!-- Created default checkbox with wildcard value-->		
			
			<label class="radio"><input name="nation" value="%" checked="checked" type="radio">All Nationalities </label>

    		<?php
   	 		while (mysqli_stmt_fetch($stmt)) {
    			?>		 
	               	<label class="radio">
	                  <input name="nation" value="<?= $nationality ?>" type="radio">
	                  <?= $nationality ?> 
	                </label>
	  
   				<?php
   	 		}

   	 	mysqli_stmt_close($stmt);
			?>
		
		
		</div>
	</div>
          
			<!-- generate select boxed of keywords from the database-->		
			
			<div class="control-group">
				<label class="control-label" for="Select">Keywords</label>
				<div class ="controls">
		   		 	<select name="terms">
						   <!-- create default with wildcard value-->	
					<option name="terms" selected="selected" value="%"> All Terms </option>
						 <?php 
						//get all terms for the dropdown
						// connect and get $con object
						include("mysql_connect.php");

						// Prepare query: What are the term names and term ids?
						$stmt = mysqli_prepare($con, "SELECT DISTINCT term_name, id FROM Terms ORDER BY Terms.term_name ASC");

						mysqli_stmt_execute($stmt);

						mysqli_stmt_bind_result($stmt, $term, $termid);
						?>
		
								  <?php
								  //include term ids as values and place term names as display
					 			  while (mysqli_stmt_fetch($stmt)) {
									  ?>		 
									      <option name="terms" value="<?= $term ?>"><?= $term ?></option>

								<?php
					 		}
							mysqli_stmt_close($stmt);
							?>
					
					</select>
				</div>
		    </div>
			
				
				

	            <div class="form-actions">
	              <button type="reset" class="btn">Cancel</button>
				  <input type="submit" value="Submit" class="btn btn-primary"/>
	            </div>
	          </fieldset>
	        </form>
    
		</div>
	</div>	   <!-- row -->
	</div> 	   <!-- container-->
	
	   <!-- PHP GOES HERE -->
	
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
	</body>
    </html>