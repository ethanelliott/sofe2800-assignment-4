<?php
$saltLength = 10;
function generateSalt() {
  global $saltLength;
  $chars = "abcdefghijklmnopqrstuvwxyz1234567890";
  $retStr = "";
  for($i = 0; $i < $saltLength; $i++) {
    $retStr .= $chars[rand(0, strlen($chars)-1)];
  }
  return $retStr;
}
function saltAndHash($pass) {
  $salt = generateSalt();
  return $salt . "" . md5($pass . $salt);
}

function validatePassword($rawPass, $hashedPass) {
  global $saltLength;
  $salt = substr($hashedPass, 0, $saltLength);
  $modRawPass = $salt . md5($rawPass . $salt);
  return $hashedPass === $modRawPass;
}

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql_servername = "localhost";
$sql_username =   "ethanell_hbs";
$sql_password =   "password123";
$sql_dbname =     "ethanell_sofe2800";
$con = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
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
<!doctype html>
<html>
<head>
  <?php

   ?>
</head>
</html>
