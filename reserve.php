<?php
	session_start();

	$room_id = $_GET['rmid'];
	$hotel_id = $_GET['htid'];

	$_SESSION['roomid'] = $room_id;
	$_SESSION['hotelid'] = $hotel_id;
	$_SESSION['returnafterlogin'] = true;
	$_SESSION['url'] = $_GET['url'];

	$servername = "localhost";
	$username =   "ethanell_hbs";
	$password =   "password123";
	$dbname =     "ethanell_sofe2800";
	$con = new mysqli($servername, $username, $password, $dbname);
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"room");
	$sql="SELECT * FROM room WHERE Rm_id = '" . $_SESSION['roomid'] . "'";
	$result = mysqli_query($con,$sql);
	if ($result->num_rows === 1) {
		$row = $result->fetch_assoc();
		$_SESSION['room_info'] = $row;
	}

	mysqli_select_db($con,"room_type");
	$sql="SELECT * FROM room_type WHERE Typ_id = '" . $_SESSION['room_info']['room_type_id'] . "'";
	$result = mysqli_query($con,$sql);
	if ($result->num_rows === 1) {
		$row = $result->fetch_assoc();
		$_SESSION['room_info']['room_typ_description'] = $row['Typ_description'];
	}

	mysqli_select_db($con,"hotel");
	$sql="SELECT * FROM hotel WHERE Htl_id = '" . $_SESSION['hotelid'] . "'";
	$result = mysqli_query($con,$sql);
	if ($result->num_rows === 1) {
		$row = $result->fetch_assoc();
		$_SESSION['hotel_info'] = $row;
	}

	mysqli_close($con);

	echo $room_id . "<br />";
	echo $hotel_id . "<br />";
	echo $_SESSION['url'];

 ?>

<!doctype html>
<html>

<head>
  <?php
   if ((!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
     echo '<meta http-equiv="refresh" content="0;url=login.php" />';
   }
   ?>
	<title>West Bestern | Reserve</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="style/ess.css" rel="stylesheet" type="text/css" media="screen">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script type="text/javascript" src="script/e.js"></script>
	<script>
		let t = false;

		function toggle(setT) {
			if (setT != undefined) {
				t = setT;
			} else {
				t = !t;
			}
			if (t) {
				$(".ess-menu").css({"left":"0"});
				$("body").css({"left":"60vw"});
				$(".ess-head").css({"left":"60vw"});
			} else {
				$(".ess-menu").css({"left":"-60vw"});
				$("body").css({"left":"0"});
				$(".ess-head").css({"left":"0"});
			}
		}

		function quickSnack($message, $timeout, $callback) {
			let snack = $("#snack.ess-snack");
			snack.innerHTML = $message;
			snack.fadeIn(500);
			setTimeout(() => {
				snack.fadeOut(500);
				if ($callback) {
					$callback();
				}
			}, $timeout + 500);
		}

		function hexToBase64(str) {
	    	return btoa(String.fromCharCode.apply(null, str.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" ")));
		}

		function followLink($url) {
			location.href=$url;
		}

		var saltLength = 20;
		var generateSalt = function() {
			var set = '0123456789abcdefghijklmnopqurstuvwxyzABCDEFGHIJKLMNOPQURSTUVWXYZ';
			var salt = '';
			for (var i = 0; i < saltLength; i++) {
				var p = Math.floor(Math.random() * set.length);
				salt += set[p];
			}
			return salt;
		};
	</script>
	<script>
	function pageInit() {

	}
	window.onload = () => {
		pageInit();
	}
	</script>
</head>

<body>
	<div class="ess-head">
		<div class="ess-wrapper">
			<div class="ess-row wide">
				<div class="ess-mobile-menu-button" onclick="toggle()"></div>
				<h1 class="ess-logo">
					<a href="javascript:void(0);"><i class="fa fa-bed"></i>&nbsp;West Bestern</a>
				</h1>
				<div class="ess-menu">
					<a href="index.php" class="ess-menu-item">Home</a>
					<a href="about.php" class="ess-menu-item">About</a>
					<div class="ess-menu-item ess-dropdown">
						Member
						<div class="ess-menu-dropdown">
              				<?php
								if (!isset($_SESSION['loggedin'])) {
									echo '<a href="login.php" class="ess-menu-item">Login</a><a href="register.php" class="ess-menu-item">Register</a>';
								} else {
									echo '<a href="userinfo.php" class="ess-menu-item">Profile</a><a href="logout.php" class="ess-menu-item">logout</a>';
								}
							 ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ess-main" onclick="toggle(false)">
		<div id="banner-container" class="ess-wrapper"></div>
		<div class="ess-wrapper">
      <div class="ess-card" style="max-width:550px;">
        <h1 class="ess-center">Reservation Confirmation</h1>
		<div id="table-container"></div>
		<div class="ess-row">
			<input type="button" value="Confirm!" class="ess-button" onclick="followLink('billing.php')" />
		</div>
		<script>
			function moneyFormat(c) {
				if (c === 0) {
					return "$ - ";
				}
				c = c.toFixed(2);
				c = c.toString();
				let rtrstr = "$";
				for (let i = 0; i < (c.length-3); i++) {
					rtrstr += c[i];
					if (i % 3 === 0 && i != c.length-4 && (c.length > 6)) {
						rtrstr += ",";
					}
				}
				rtrstr += "." + c[c.length-2] + c[c.length-1];
				return rtrstr;
			}
			let sess = <?php echo json_encode($_SESSION) ?>;
			console.log(sess);
			let to = "";
			to += "<table>";
			to += "<tr>";
			to += "<td>Hotel</td>";
			to += "<td> " + sess.hotel_info.Htl_name + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Room Type</td>";
			to += "<td>" + sess.room_info.room_typ_description + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Check-In</td>";
			to += "<td>" + sess.checkin + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Check-Out</td>";
			to += "<td>" + sess.checkout + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Number of nights</td>";
			to += "<td>" + sess.checkdiff + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Cost for weeknights (" + sess.weekday_count + " x " + moneyFormat(parseInt(sess.room_info.Rm_price)) + ")</td>";
			to += "<td>" + moneyFormat(sess.weekday_count * parseInt(sess.room_info.Rm_price)) + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Cost for weekend nights (" + sess.weekend_count + " x " + moneyFormat(parseInt(sess.room_info.Rm_price_weekend)) + ")</td>";
			to += "<td>" + moneyFormat(sess.weekend_count * parseInt(sess.room_info.Rm_price_weekend)) + "</td>";
			to += "</tr>";
			to += "<tr>";
			let subtotal = (sess.weekend_count * parseInt(sess.room_info.Rm_price_weekend) + (sess.weekday_count * parseInt(sess.room_info.Rm_price)));
			to += "<td>Subtotal</td>";
			to += "<td>" + moneyFormat(subtotal) + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Tax</td>";
			to += "<td>" + moneyFormat(subtotal * 0.13) + "</td>";
			to += "</tr>";
			to += "<tr>";
			to += "<td>Total</td>";
			to += "<td>" + moneyFormat(subtotal * 1.13) + "</td>";
			to += "</tr>";
			to += "</table>";
			$("#table-container").html(to);
		</script>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
