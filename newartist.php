 <!DOCTYPE html>
 <html>

    <head>
    <title>Blanton Museum of Art Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrapSpacelab.css" rel="stylesheet" media="screen">
    </head>
    
    
   <?php
 		// Have to include this as first line of each page that 
		// you want to use session
		session_start();
		
	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli conneciton $con
	    
	     
	    // Check connection
		if (mysqli_connect_errno())
  			{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  			}

	//Check if the form has already been submitted. If so, create the record.
	if (isset($_POST['submitted'])) {

        $stmt = mysqli_prepare($con, "INSERT INTO Artist (last, first, birth, death, nationality) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'ssiis', $_POST['last'], $_POST['first'], $_POST['birth'], $_POST['death'], $_POST['nationality']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
		$message = "New artist created successfully. Do you want to add another?";

	}//if submitted
    
  ?>  
    
    
	<body>
	    <div class="container">
	  	<div class="row-fluid">
	  		<div class="span12">
	  			<div class="page-header">
	  			  <h2>New Artist
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
	        
	  	        <form class="form-horizontal well" action="#" method="post">
	  	          <fieldset>
	  	            <legend>Please complete all the fields below</legend>
	         
				
				
				<!-- Artist First Name -->
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Artist First Name</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="first">
			            </div>
			          </div>	
				
	  	        <!-- Artist Last Name-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Artist Last Name</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="last">
					  	</div>
			          </div>
				
				<!-- Birth Year-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Year of Birth</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="birth">
					  	</div>
			          </div>
				
				<!-- Death Year-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Year of Death</br>(leave blank if still living)</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="death">
			            </div>
			          </div>
				
				<!-- Nationality-->	
				
			    <div class="control-group">
			            <label class="control-label" for="input01">Nationality</label>
			            <div class="controls">
			              <input type="text" class="input-xlarge" id="input01" value="" name="nationality">
			            </div>
			          </div>

	  	            <div class="form-actions">
	  	              <input type="hidden" name="submitted" value="true" />
	  	              <button type="submit" class="btn btn-primary btn-large">Submit</button>
	  	            </div>
	  	          </fieldset>
	  	        </form>
    
	  		</div>
	  	</div>	   <!-- row -->
	  	</div> 	   <!-- container-->

</body>
</html>
