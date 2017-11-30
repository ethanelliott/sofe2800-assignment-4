<?php
	session_start();
	$_SESSION['username'] = "";
	$_SESSION['firstname'] = "";
	$_SESSION['lastname'] = "";
	$_SESSION['email'] = "";
	$_SESSION['memsince'] = "";
	$_SESSION['loggedin'] = false;
	session_destroy();
 ?>
 <!doctype html>
 <html>
 <head>
 	<?php
 		echo '<meta http-equiv="refresh" content="0;url=index.php" />';
 	?>
 </head>
 </html>
