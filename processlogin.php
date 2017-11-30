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

  $uname = $_POST['uname'];
  $upass = $_POST['upass'];
 ?>
<!doctype html>
<html>
<head>
  <?php

   ?>
</head>
</html>
