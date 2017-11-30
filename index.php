<?php
	session_start();
 ?>
<!doctype html>
<html>

<head>
	<title>West Bestern</title>
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
				$(".ess-menu").style.left = "0";
				$("body").style.left = "60vw";
				$(".ess-head").style.left = "60vw";
			} else {
				$(".ess-menu").style.left = "-60vw";
				$("body").style.left = "0";
				$(".ess-head").style.left = "0";
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

		function AJAXrequest($url, $method, $callback) {
			let xmlhttp;
			if (window.XMLHttpRequest) {
				xmlhttp=new XMLHttpRequest();
			} else {
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function() {
				if (this.readyState==4 && this.status==200) {
					$callback(this.responseText);
				}
			}
			xmlhttp.open($method, $url ,true);
			xmlhttp.send();
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

	function showCity($str) {
		if ($("#provinceSelect option[value='empty']") != null) {
			$("#provinceSelect option[value='empty']").remove();
		}
		$("#citySelect").innerHTML = $str;
		if ($str=="") {
			$("#citySelect").innerHTML="";
			return;
		}
		AJAXrequest("getcity.php?q="+$str, "GET", (data)=>{
			$("#citySelect").innerHTML = data;
		});
	}

	function showSearchResults() {
		let cityID = $("#citySelect").value;
		AJAXrequest("getHotel.php?city="+cityID, "GET", (data)=>{
			$("#searchResultCards").innerHTML = data;
			$("#searchResults").fadeIn(1000);
		});
	}

	function pageInit() {
		if ($("#provinceSelect").value != "empty") {
			//showCity($("#provinceSelect").value);
		}

		$("#searchHotelBTN").click(() => {
			let banCon = $("#banner-container");

			if ($("#adultCount").value == "0") {
				let hashID = generateSalt();
				let banner = '<div id=' + hashID + ' class="ess-banner ess-danger"><i class="fa fa-exclamation-triangle"></i><span>Warning! Cannot book room with 0 adults!</span></div>';
				banCon.innerHTML = banCon.innerHTML + banner;
				let bannerObj = $("#" + hashID);
				bannerObj.fadeIn(100);
				setTimeout(() => {
					bannerObj.fadeOut(100);
					bannerObj.remove();
				}, 10000);
			} else {
				showSearchResults();
				banCon.innerHTML = "";
			}
		});

		let today = new Date();
		let tomorrow = today.getFullYear() + "-" + (today.getMonth() +1) + "-" + (today.getDate() +1);
		let nextYear = (today.getFullYear()+1) + "-" + (today.getMonth() +1) + "-" + (today.getDate() +1);
		let dayAfterTomorrow = today.getFullYear() + "-" + (today.getMonth() +1) + "-" + (today.getDate() +2);
		$("#checkin").setAttribute("min", tomorrow);
		$("#checkin").setAttribute("max", nextYear);
		$("#checkin").value = tomorrow;
		$("#checkout").setAttribute("min", dayAfterTomorrow);
		$("#checkout").setAttribute("max", nextYear);
		$("#checkout").value = dayAfterTomorrow;

		$("#checkin").addEventListener('change', () => {
			let selectedDate = new Date($("#checkin").value);
			let afterSelectedDate = selectedDate.getFullYear() + "-" + (selectedDate.getMonth() +1) + "-" + (selectedDate.getDate() +2);
			$("#checkout").setAttribute("min", afterSelectedDate);
			$("#checkout").value = afterSelectedDate;
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
									echo '<a href="userinfo.php" class="ess-menu-item">Profile</a>';
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

		</div>
		<div class="ess-wrapper">
			<h1 class="ess-full">Find a hotel room</h1>
			<div id="hotelSearch" class="ess-card">
				<form>
					<div class="ess-row-left">
						<h4>Province: </h4>
						<select name="Province" id="provinceSelect" onchange="showCity(this.value)">
							<option value="empty">--Select a province--</option>
							<?php
								$servername = "localhost";
								$username =   "ethanell_hbs";
								$password =   "password123";
								$dbname =     "ethanell_sofe2800";
								$conn = new mysqli($servername, $username, $password, $dbname);
								// Check connection
								if ($conn->connect_error) {
									die("Connection failed: " . $conn->connect_error);
								}
								$sql = "SELECT prv_id, prv_name FROM province;";
								$result = $conn->query($sql);
								if ($result->num_rows > 0) {
									// output data of each row
									while($row = $result->fetch_assoc()) {
										echo "<option value=". $row["prv_id"].">" . $row['prv_name'] . "</option>";
									}
								} else {
									echo "0 results";
								}
								$conn->close();
							?>
						</select>
						<h4>City: </h4>
						<select id="citySelect"></select>
					</div>
					<div class="ess-row-left">
						<h4>Check-in: </h4><input id="checkin" type="date" />
						<h4>Check-out: </h4><input id="checkout" type="date" />
					</div>
					<div class="ess-row-left">
						<h4>Adults: </h4>
						<select id="adultCount">
							<?php
							for ($i = 0; $i <= 5; $i++) {echo "<option value=" . $i . ">" . $i . "</option>\n";}
							?>
						</select>
						<h4>Children: </h4>
						<select id="childCount">
							<?php
							for ($i = 0; $i <= 5; $i++) {echo "<option value=" . $i . ">" . $i . "</option>\n";}
							?>
						</select>
					</div>
					<div class="ess-row-right">
						<input id="searchHotelBTN" type="button" value="Search" />
					</div>
				</form>
			</div>
	</div>
	<div id="searchResults" class="ess-wrapper ess-hidden">
		<h1 class="ess-full">Results</h1>
		<div id="searchResultCards" class="ess-row-left"></div>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
