<?php

$response = array(
	'valid' => false,
	'message' => 'FATAL ERROR'
);

if (isset($_POST['username'])) {
	$servername = "localhost";
	$username =   "ethanell_hbs";
	$password =   "password123";
	$dbname =     "ethanell_sofe2800";
	$con = new mysqli($servername, $username, $password, $dbname);
	if (!$con) {die('Could not connect: ' . mysqli_error($con));}
	mysqli_select_db($con,"guest");

	$sql = "SELECT * FROM guest WHERE Gst_username = '" . $_POST['username'] . "'";
	$result = mysqli_query($con, $sql);
	if ($result->num_rows === 1) {
		$response = array(
			'valid' => false,
			'message' => 'Username already taken!'
		);
	} else {
		$response = array(
			'valid' => true
		);
	}
	mysqli_close($con);
}

echo json_encode($response);

?>
