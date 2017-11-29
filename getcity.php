<?php
$q = intval($_GET['q']);
$servername = "localhost";
$username =   "ethanell_hbs";
$password =   "password123";
$dbname =     "ethanell_sofe2800";
$con = new mysqli($servername, $username, $password, $dbname);
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"city");
$sql="SELECT * FROM city WHERE Cty_province_id = '".$q."'";
$result = mysqli_query($con,$sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<option value=". $row["Cty_id"].">" . $row['Cty_Name'] . "</option>";
	}
} else {
	echo "<option value='err'>No Results</option>";
}

mysqli_close($con);
?>
