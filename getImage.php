<?php
$hotelid = intval($_GET['hotelid']);
$servername = "localhost";
$username =   "ethanell_hbs";
$password =   "password123";
$dbname =     "ethanell_sofe2800";
$con = new mysqli($servername, $username, $password, $dbname);
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_select_db($con,"pictures");
$sql="SELECT * FROM pictures WHERE hotel_id = '" . $hotelid . "'";
$result = mysqli_query($con,$sql);
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
      echo base64_encode($row['image']);
  }
}

mysqli_close($con);
?>
