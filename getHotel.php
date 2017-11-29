<?php
$city = intval($_GET['city']);
$servername = "localhost";
$username =   "ethanell_hbs";
$password =   "password123";
$dbname =     "ethanell_sofe2800";
$con = new mysqli($servername, $username, $password, $dbname);
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"hotel");
$sql="SELECT * FROM hotel WHERE Htl_city_id = '" . $city . "'";
$result = mysqli_query($con,$sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$imageData = "";
		mysqli_select_db($con,"pictures");
		$img_sql="SELECT * FROM pictures WHERE hotel_id = '" . $row["Htl_id"] . "'";
		$img_result = mysqli_query($con,$img_sql);
		if ($img_result->num_rows > 0) {
		  while($img_row = $img_result->fetch_assoc()) {
		      $imageData = base64_encode($img_row['image']);
		  }
		}

		echo "<div class=\"ess-price-column\">";
		echo "<ul>";
		echo "<li class=\"ess-price-column-header\">" . $row["Htl_name"] . "</li>";
		echo "<li class=\"ess-price-column-image\" style=\"background-image: url('data:image/png;base64," . $imageData . "')\" ></li>";
		echo "<li class=\"ess-price-column-info\"><p>" . $row["Htl_address"] . "</p></li>";
		echo "<li class=\"ess-price-column-button\"><input type=\"button\" value=\"View Deal\" class=\"ess-button\" onclick=\"followLink('hotelinfo.php?hotelid=" . $row['Htl_id'] . "');\"></li>";
		echo "</ul>";
		echo "</div>";
	}
} else {
	echo "<h2>No Results Found.</h2>";
}

mysqli_close($con);
?>
