
 <!DOCTYPE html>
 <html>
     <!-- Connect to the database and get the header-->
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
		
	    <div class="container">
	  	<div class="row-fluid">
	  		<div class="span12">
			    <div class="page-header">
			       <h1>Artwork Entry</h1>
			     </div>
    <!-- Connect to the prior page and conduct a search of mysql based on the artist id from the selected button -->
		<?php 
		//write the query
		$workquery = "SELECT Artwork.thumbnail, Artist.first, Artist.last, Artwork.title, Artwork.date, Artwork.medium, Artwork.credit, Artist.nationality,  Artist.birth, Artist.death, Terms.term_name, Video.video_title, Video.length, Video.vidcredit, Artwork.accessionnum FROM Artist, Artwork, Terms, Video WHERE Artwork.artist_id=Artist.id AND Artwork.term_id = Terms.id AND Terms.id = Video.term_id AND Artist.id = ?";
		
		//prepare the query and bind params
		$stmt = mysqli_prepare($con, $workquery);	
		mysqli_stmt_bind_param($stmt, "i", $_GET["artist_page"]);
		
		//execute and bind
		mysqli_stmt_execute($stmt);
		
		mysqli_stmt_bind_result($stmt, $img, $first, $last, $title, $date, $medium, $credit, $nation, $birth, $death, $term, $vidtitle, $vidlength, $vidcredit, $anum);
		?>
		    <!-- Write the entry page using variables fetched & bound to the stmt above -->
		<?php		
        while (mysqli_stmt_fetch($stmt)) {
        ?>    
			     <div class="row">

  			       <div class="span6">
  			     <img src="<?= $img; ?>" alt-"Database Image" title="Artwork Image"/>
  			       </div>


			       <div class="span6">
			         <div class="well">
			           <h3><strong><?= $first?> <?= $last ?></strong> </h3>
			           <h5><?= $nation?> (b.<?= $birth?>- d.<?= $death ?>)</h5>
				   		</br>
					   <h4><em><?= $title ?></em>, <?= $date ?></h4>
					   <h4><?= $medium ?></h4>
			           <h4><?= $credit ?></h4>
					   </br>
			           <h4><?= $anum ?></h4>
			         </div>
			       </div>
			   </div>
		   </br>
		   </br>
		    <div class="page-header">
		       <h3></h2>
		     </div>
			   
			   <div class="row">
			       
			       <div class="span6">
			      
			           <h3>Video</h3>
				   		</br>
					   <h4>Title:<em><?= $vidtitle ?></em></h2>
					   <h4>Length: <?= $vidlength ?></h3>
					   <h4>Credit: <?= $vidcredit ?></h3>
						
			       </div>
				   
				   
				   <div class="span6">
			        <h3>Related Terms</h3>
				 	</br>
					<h4><em><?= $term ?></em></h4>
						
						<p> Description of this term sounds like lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
			       </div>
			   
			   </div>
			     <!-- Close out the stmt -->  
			  
	        <?php
	        }//end the while

	        mysqli_stmt_close($stmt);
	        
	        ?>
  
			</div>
			
			 <div class="row">
			 </br>
		 	 </br>
			 </div>
		</div>
	</div>

</body>
</html>