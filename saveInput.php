<?php
	session_start();
	if (isset($_POST['province'])) {
		$_SESSION['province'] = $_POST['province'];
		$_SESSION['city'] = $_POST['city'];
		$_SESSION['childcount'] = $_POST['childcount'];
		$_SESSION['adultcount'] = $_POST['adultcount'];
		$_SESSION['checkin'] = $_POST['checkin'];
		$_SESSION['checkout'] = $_POST['checkout'];
		$dadif = date_diff(date_create($_SESSION['checkin']), date_create($_SESSION['checkout']));
		$_SESSION['checkdiff'] = intval($dadif->format("%a"));

		$checkin = new DateTime($_SESSION['checkin']);
		$weekEndCount = 0;
		for ($i = 0; $i < $_SESSION['checkdiff']; $i++) {
			switch($checkin->format("l")) {
				case "Saturday":
				case "Sunday":
					$weekEndCount++;
					break;
			}
			date_add($checkin, date_interval_create_from_date_string('1 day'));
		}
		$_SESSION['weekend_count'] = $weekEndCount;
		$_SESSION['weekday_count'] = $_SESSION['checkdiff'] - $weekEndCount;

		$servername = "localhost";
		$username =   "ethanell_hbs";
		$password =   "password123";
		$dbname =     "ethanell_sofe2800";
		$con = new mysqli($servername, $username, $password, $dbname);
		if (!$con) {
			die('Could not connect: ' . mysqli_error($con));
		}

		mysqli_select_db($con,"province");
		$sql="SELECT * FROM province WHERE Prv_id = '" . $_SESSION['province'] . "'";
		$result = mysqli_query($con,$sql);
		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
			$_SESSION['province_name'] = $row['Prv_Name'];
		}

		mysqli_select_db($con,"city");
		$sql="SELECT * FROM city WHERE Cty_id = '" . $_SESSION['city'] . "'";
		$result = mysqli_query($con,$sql);
		if ($result->num_rows === 1) {
			$row = $result->fetch_assoc();
			$_SESSION['city_name'] = $row['Cty_Name'];
		}

		mysqli_close($con);
	}
 ?>
