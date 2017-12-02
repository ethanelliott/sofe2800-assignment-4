<!doctype html>
<html>
<head>
	<title>West Bestern</title>
	<?php
     if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
       echo '<meta http-equiv="refresh" content="0;url=userinfo.php" />';
     }
     ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="style/ess.css" rel="stylesheet" type="text/css" media="screen">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

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
		$.validate({
			modules : 'security, toggleDisabled',
			disabledFormFilter : 'form.toggle-disabled',
			errorMessagePosition : 'top',
			onModulesLoaded : function() {
				var optionalConfig = {
					fontSize: '12pt',
					padding: '4px',
					bad : 'Very bad',
					weak : 'Weak',
					good : 'Good',
					strong : 'Strong'
				};
				$('input[name="password_confirmation"]').displayPasswordStrength(optionalConfig);
			}
		});
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
			<div class="ess-card" style="max-width:500px;">
				<h1 class="ess-center">Register</h1>
				<p id="error-dialog" class="ess-center" style="color:red;font-weight:bold;font-style:italic;"></p>
				<form class="toggle-disabled" method="post" action="processregister.php">
					<p class="ess-form-label">First Name:</p><input name="first_name" type="text" data-validation-error-msg-container="#error-dialog" data-validation="required" /><br />
					<p class="ess-form-label">Last Name:</p><input name="last_name" type="text" data-validation-error-msg-container="#error-dialog" data-validation="required" /><br />
					<p class="ess-form-label">Username:</p><input name="username" type="text" data-validation-error-msg-container="#error-dialog" data-validation="required server" data-validation-url="validate-username.php" /><br />
					<p class="ess-form-label">Email:</p><input name="email" type="text" data-validation-error-msg-container="#error-dialog" data-validation="email required" /><br />
					<p class="ess-form-label">Password:</p><input name="password_confirmation" type="password" data-validation-error-msg-container="#error-dialog"  data-validation="strength required" data-validation-strength="2" /><br />
					<p class="ess-form-label">Password Confirm:</p><input name="password" type="password" data-validation-error-msg-container="#error-dialog" data-validation="confirmation required" /><br />
					<div class="ess-row-right">
						<input class="ess-button" type="submit" value="Register" />
					</div>
				</form>
				<h4 class="ess-center">Already have an account? <a href="login.php">Click here to login!</a></h4>
			</div>
		</div>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
