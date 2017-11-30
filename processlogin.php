<?php
	session_start();
	$saltLength = 10;
	function generateSalt() {
		global $saltLength;
		$chars = "abcdefghijklmnopqrstuvwxyz1234567890";
		$retStr = "";
		for($i = 0; $i < $saltLength; $i++) {
			$retStr .= $chars[rand(0, strlen($chars)-1)];
		}
		return $retStr;
	}
	function saltAndHash($pass) {
		$salt = generateSalt();
		return $salt . "" . md5($pass . $salt);
	}

	function validatePassword($rawPass, $hashedPass) {
		global $saltLength;
		$salt = substr($hashedPass, 0, $saltLength);
		$modRawPass = $salt . md5($rawPass . $salt);
		return $hashedPass === $modRawPass;
	}
	$error = false;
	$uname = $_POST['uname'];
	$upass = $_POST['upass'];

	$servername = "localhost";
	$username =   "ethanell_hbs";
	$password =   "password123";
	$dbname =     "ethanell_sofe2800";
	$con = new mysqli($servername, $username, $password, $dbname);
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"guest");
	$sql="SELECT * FROM guest WHERE Gst_username = '" . $uname . "'";
	$result = mysqli_query($con,$sql);
	if ($result->num_rows === 1) {
		$row = $result->fetch_assoc();
		if (validatePassword($upass, $row['Gst_password'])) {
			$_SESSION['username'] = $row['Gst_username'];
			$_SESSION['firstname'] = $row['Gst_first_name'];
			$_SESSION['lastname'] = $row['Gst_last_name'];
			$_SESSION['email'] = $row['Gst_email'];
			$_SESSION['memsince'] = $row['Gst_member_since'];
			$_SESSION['loggedin'] = true;
		} else {
			$_SESSION['username'] = "";
			$_SESSION['firstname'] = "";
			$_SESSION['lastname'] = "";
			$_SESSION['email'] = "";
			$_SESSION['memsince'] = "";
			$_SESSION['loggedin'] = false;
			session_destroy();
			$error = true;
		}
	} else {
		$_SESSION['username'] = "";
		$_SESSION['firstname'] = "";
		$_SESSION['lastname'] = "";
		$_SESSION['email'] = "";
		$_SESSION['memsince'] = "";
		$_SESSION['loggedin'] = false;
		session_destroy();
		$error = true;
	}
	mysqli_close($con);
?>
<!doctype html>
<html>
<head>
	<?php
		if ($error) {
			echo '<meta http-equiv="refresh" content="0;url=login.php?error=1" />';
		} else {
			echo '<meta http-equiv="refresh" content="0;url=userinfo.php" />';
		}
	?>
</head>
</html>
