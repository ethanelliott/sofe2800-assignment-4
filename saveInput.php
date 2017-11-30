<?php
	session_start();
	if (isset($_POST['province'])) {
		$_SESSION['province'] = $_POST['province'];
		$_SESSION['city'] = $_POST['city'];
		$_SESSION['childcount'] = $_POST['childcount'];
		$_SESSION['adultcount'] = $_POST['adultcount'];
		$_SESSION['checkin'] = $_POST['checkin'];
		$_SESSION['checkout'] = $_POST['checkout'];
	}
	echo '{"response":"success", "data": "' . var_dump($_SESSION) . '"}';
 ?>
