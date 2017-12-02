<?php
session_start();
 ?>
<!doctype html>
<html>

<head>
  <?php
   if ((!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'])) {
     echo '<meta http-equiv="refresh" content="0;url=login.php" />';
   }
   ?>
	<title>West Bestern | Billing Info</title>
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
        <h1 class="ess-center">Billing Information</h1>
		<form method="POST" action="sendconfirm.php">
			<div class="ess-row">
				<p class="ess-form-label">First Name: </p>
				<input id="fname" name="fname" type="text" placeholder="John" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Last Name: </p>
				<input id="lname" name="lname" type="text" placeholder="Smith" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Email: </p>
				<input id="email" name="email" type="text" placeholder="johnsmith@email.com" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Street Address: </p>
				<input id="address" name="address" type="text" placeholder="123 Main St." required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">City: </p>
				<input id="city" name="city" type="text" placeholder="Hamilton" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Postal Code: </p>
				<input id="postal" name="postal" type="text" placeholder="L#L #L#" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Country: </p>
				<input id="country" name="country" type="text" placeholder="Canada" required />
			</div>
			<div class="ess-row">
				<p class="ess-form-label">Phone Number: </p>
				<input id="phone" name="phone" type="text" placeholder="(###) - ### - ####" required />
			</div>
			<div class="ess-row">
				<input type="submit" class="ess-button" value="Submit" />
			</div>
		</form>
		<script>
			let sess = <?php echo json_encode($_SESSION) ?>;
			console.log(sess);
			$("#fname").val(sess.firstname);
			$("#lname").val(sess.lastname);
			$("#email").val(sess.email);
		</script>
      </div>
		</div>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
