<!doctype html>
<html>
<head>
	<title>West Bestern</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<link href="style/ess.css" rel="stylesheet" type="text/css" media="screen">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script>
		let $ = document.querySelector.bind(document);

		Object.defineProperty(HTMLElement.prototype,'click',{
			value:function($callback){
				this.addEventListener("click", $callback);
			},
			writable:false,
			enumerable:false
		});

		Object.defineProperty(HTMLElement.prototype,'fadeIn',{
			value:function($timeout){
				$timeout = $timeout || 400;
				let el = this;
				el.style.display = "inherit";
				el.style.opacity = 0;
				var last = +new Date();
				var tick = function() {
					el.style.opacity = +el.style.opacity + (new Date() - last) / $timeout;
					last = +new Date();
					if (+el.style.opacity < 1) {
						(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
					}
				};
				tick();
			},
			writable:false,
			enumerable:false
		});
		Object.defineProperty(HTMLElement.prototype,'fadeOut',{
			value:function($timeout){
				$timeout = $timeout || 400;
				let el = this;
				el.style.display = "inherit";
				el.style.opacity = 1;
				var last = +new Date();
				var tick = function() {
					el.style.opacity = +el.style.opacity - (new Date() - last) / $timeout;
					last = +new Date();
					if (+el.style.opacity > 0) {
						(window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);

					} else {
						el.style.display = "none";
					}
				};
				tick();
			},
			writable:false,
			enumerable:false
		});

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

		function quickSnack($snackID, $message, $timeout, $callback) {
			let snack = $("#" + $snackID + ".ess-snack");
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
							<a href="login.php" class="ess-menu-item">Login</a>
							<a href="register.php" class="ess-menu-item">Register</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="ess-main" onclick="toggle(false)">
		<div class="ess-wrapper">
			<div class="ess-banner ess-info ess-hidden"><i class="fa fa-info-circle"></i><span>Info</span></div>
		</div>
		<div class="ess-wrapper">
			<div id="searchResultCards" class="ess-row-left">
				<?php
					$hotelid = $_GET['hotelid'];

					$servername = "localhost";
					$username =   "ethanell_hbs";
					$password =   "password123";
					$dbname =     "ethanell_sofe2800";
					$con = new mysqli($servername, $username, $password, $dbname);
					if (!$con) {
					    die('Could not connect: ' . mysqli_error($con));
					}

					mysqli_select_db($con,"room");
					$sql="SELECT * FROM room WHERE Rm_Hotel_id = '" . $hotelid . "'";
					$result = mysqli_query($con,$sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$rm_type = "";
							$rm_smoke = "";
							$rm_parking = "";
							$rm_breakfast = "";
							$rm_internet = "";

							mysqli_select_db($con,"room_type");
							$rmtype_sql="SELECT * FROM room_type WHERE Typ_id = '" . $row["room_type_id"] . "'";
							$rmtype_result = mysqli_query($con,$rmtype_sql);
							if ($rmtype_result->num_rows > 0) {
								while($rmtype_row = $rmtype_result->fetch_assoc()) {
									$rm_type = $rmtype_row['Typ_description'];
								}
							}

							if ($row["Rm_smoke"] == 1) {
								$rm_smoke = "Smoking";
							} else {
								$rm_smoke = "Non Smoking";
							}

							if ($row["Rm_free_barking"] == 1) {
								$rm_parking = "Free Parking";
							} else {
								$rm_parking = "Parking Not Included";
							}

							if ($row["Rm_free_breakfast"] == 1) {
								$rm_breakfast = "Free Breakfast";
							} else {
								$rm_breakfast = "Breakfast Not Included";
							}

							if ($row["Rm_free_internet"] == 1) {
								$rm_internet = "Free Internet";
							} else {
								$rm_internet = "Internet Not Included";
							}

							echo "<div class=\"ess-price-column\">";
							echo "<ul>";
							echo "<li class=\"ess-price-column-header\">" . $rm_type . "</li>";
							echo "<li class=\"ess-price-column-price\">$" . $row["Rm_price"] . ".00</li>";
							echo "<li class=\"ess-price-column-info\"><p>" . $rm_smoke . "</p></li>";
							echo "<li class=\"ess-price-column-info\"><p>" . $row["Rm_number_beds"] . " beds</p></li>";
							echo "<li class=\"ess-price-column-info\"><p>" . $rm_parking . "</p></li>";
							echo "<li class=\"ess-price-column-info\"><p>" . $rm_breakfast . "</p></li>";
							echo "<li class=\"ess-price-column-info\"><p>" . $rm_internet . "</p></li>";
							echo "<li class=\"ess-price-column-button\"><input type=\"button\" value=\"Reserve\" class=\"ess-button ess-button-disabled\"></li>";
							echo "</ul>";
							echo "</div>";
						}
					}

					mysqli_close($con);
				 ?>
			</div>
		</div>
	</div>
	<div class="ess-footer">
		<span>&copy; Ethan Elliott 2017</span>
	</div>
	<div class="ess-snack" id="snack"></div>
</body>

</html>
