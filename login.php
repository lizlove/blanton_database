 <!DOCTYPE html>
 <html>
 <?php

	    include "header.php";
	    include "mysql_connect.php"; //provides mysqli connection $con

	    // check if we're logging out.
		if ( isset( $_GET['logout'] ) && $_GET['logout'] == "YES") {
  		session_destroy();
  		$message = "Logout was successful";
  }

		// check for other messages
		if ( isset( $_SESSION['message'] )) {
  		$message = $_SESSION['message'];
  }

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
			<div class="span10">
				<div class="page-header">
				  <h2>Admin Center</h2>
			  </div>
				<p>Users with administrative rights to edit, delete, and enter new artworks please login here:
				</p>
				
  	          <!-- PHP GOES HERE -->
<body>
	<?php
		if(!empty($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['password'];

			$result = mysqli_query($con, "SELECT * FROM User WHERE name='$username' AND password='$password'");
			$num =mysqli_num_rows($result);

		if($num == 0){
		echo "It looks like you do not have administrative rights, please return to the <a href='index.php'>search page</a>.";
		
		}else{
		
		session_start();
		$_SESSION['username'] = $username;
		header("Location: http://holden.ischool.utexas.edu/~spring2013group3/admin.php");
		}

		}else{
	?>


<form action='login.php' method='post'>
   Username: <input type='text' name='username' /><br />
   Password: <input type='password' name='password' /><br /><br />
   <input type='submit' name='submit' value='Login' />
</form>
	<?php
		}
	?>
</body>
				   <!-- PHP GOES HERE -->

			</div>
		</div>
	</div>

</body>



</div>
</html>
