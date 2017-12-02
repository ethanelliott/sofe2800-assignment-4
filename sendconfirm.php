<?php
session_start();

if (isset($_POST['fname'])) {
	$first_name = $_POST['fname'];
	$last_name = $_POST['lname'];
	$email = $_POST['email'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$postal = $_POST['postal'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];

	$servername = "localhost";
	$username =   "ethanell_hbs";
	$password =   "password123";
	$dbname =     "ethanell_sofe2800";
	$con = new mysqli($servername, $username, $password, $dbname);
	if (!$con) {
		die('Could not connect: ' . mysqli_error($con));
	}

	mysqli_select_db($con,"guest");
	$sql="SELECT * FROM guest WHERE Gst_username = '" . $_SESSION['username'] . "'";
	$result = mysqli_query($con,$sql);
	if ($result->num_rows === 1) {
		$row = $result->fetch_assoc();
		$_SESSION['guestid'] = $row['Gst_id'];
	}

	mysqli_select_db($con,"room");
	$sql="UPDATE room SET Rm_status = 1 WHERE `room`.`Rm_id` = " . $_SESSION['roomid'] . "";
	$result = mysqli_query($con,$sql);

	mysqli_select_db($con,"booking");
	$sql = "INSERT INTO booking VALUES (NULL,'" . $_SESSION['checkin'] . "','" . $_SESSION['checkout'] . "', '" . $_SESSION['username'] . "', '" . $_SESSION['guestid'] . "', '" . $_SESSION['checkdiff'] . "', '" . date("Y-m-d") . "', '" . $_SESSION['roomid'] . "')";
	$result = mysqli_query($con, $sql);

	mysqli_close($con);

	$sendTo = $_SESSION['email'];
	$subject = "West Bestern Hotel Confirmation";
	$message = "
		<html>
			<head>
				<title>West Bestern Hotel Confirmation</title>
				<style>
				body {
					font-family: sans-serif;
					font-size:16px;
					color:#1a54ac;
				}
				table {
					border-collapse: collapse;
				    width: 80%;
				    transition: all 0.3s;
					color:black;
				}
				th, td {
				  text-align: left;
				  margin: 0;
				  padding: 16px;
			  	}
				tr {
				  transition: all 0.3s;
			  	}
				tr:nth-child(even) {
				  background-color: #f2f2f2;
			  	}
				tr:hover {
				  background-color: #d2d2d2;
			  	}
				th {
				  background-color: #1a54ac;
				  color: white;
			  	}
				</style>
			</head>
			<body>
				<p>Dear " . $_SESSION['firstname'] . " " . $_SESSION['lastname'] . ",</p>
				<p>Thank you for your recent booking!\nBelow is a summary of the booking: </p>
				<table>
					<tr>
						<td>Hotel</td>
						<td>" . $_SESSION['hotel_info']['Htl_name'] . "</td>
					</tr>
					<tr>
						<td>Room Type</td>
						<td>" . $_SESSION['room_info']['room_typ_description'] . "</td>
					</tr>
					<tr>
						<td>Check-In</td>
						<td>" . $_SESSION['checkin'] . "</td>
					</tr>
					<tr>
						<td>Check-Out</td>
						<td>" . $_SESSION['checkout'] . "</td>
					</tr>
					<tr>
						<td>Number of nights</td>
						<td>" . $_SESSION['checkdiff'] . "</td>
					</tr>
					<tr>
						<td>Cost for weeknights (" . $_SESSION['weekday_count'] . " x $" . intval($_SESSION['room_info']['Rm_price']) . ".00)</td>
						<td>$" . (intval($_SESSION['room_info']['Rm_price']) * intval($_SESSION['weekday_count'])) . "</td>
					</tr>
					<tr>
						<td>Cost for weekend nights (" . $_SESSION['weekend_count'] . " x $" . intval($_SESSION['room_info']['Rm_price_weekend']) .".00)</td>
						<td>$" . (intval($_SESSION['room_info']['Rm_price_weekend']) * intval($_SESSION['weekend_count'])) . "</td>
					</tr>
					<tr>
						<td>Subtotal</td>
						<td>$" . ((intval($_SESSION['room_info']['Rm_price']) * intval($_SESSION['weekday_count'])) + (intval($_SESSION['room_info']['Rm_price_weekend']) * intval($_SESSION['weekend_count']))) . "</td>
					</tr>
					<tr>
						<td>Tax</td>
						<td>$" . (((intval($_SESSION['room_info']['Rm_price']) * intval($_SESSION['weekday_count'])) + (intval($_SESSION['room_info']['Rm_price_weekend']) * intval($_SESSION['weekend_count'])))*0.13) . "</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>$" . (((intval($_SESSION['room_info']['Rm_price']) * intval($_SESSION['weekday_count'])) + (intval($_SESSION['room_info']['Rm_price_weekend']) * intval($_SESSION['weekend_count'])))*1.13) . "</td>
					</tr>
				</table>
				<p>Can't wait to see you!</p>
				<p>Sincerely,</p>
				<p>\tThe West Bestern Team :)</p>
			</body>
		</html>
	";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: West Bestern <confirm@westbestern.com>' . "\r\n";
	$headers .= 'Bcc: ee@ethanelliott.ca' . "\r\n";
	mail($sendTo, $subject, $message, $headers);
}

 ?>
<!doctype html>
<html>

<head>
  <?php
   if ((!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
     echo '<meta http-equiv="refresh" content="0;url=login.php" />';
   }
   ?>
	<title>West Bestern | Confirmed</title>
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
		<div id="banner-container" class="ess-wrapper">
			<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == 1) {
						echo '<div id="login_error" class="ess-banner ess-danger"><i class="fa fa-exclamation-triangle"></i><span>Error! invalid username / password</span></div>';
					}
				}
				if (isset($_GET['i'])) {
					if ($_GET['i'] == 4) {
						echo '<div id="info_save" class="ess-banner ess-info"><i class="fa fa-exclamation"></i><span>Error! invalid username / password</span></div>';
					}
				}
			?>
		</div>
		<div class="ess-wrapper">
      <div class="ess-card" style="max-width:550px;">
        <h1 class="ess-center">Reservation Confirmed!</h1>
        <h4 class="ess-center">An email with more information has been sent to <?php echo $_SESSION['email'] ?></h4>
      </div>
		</div>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
