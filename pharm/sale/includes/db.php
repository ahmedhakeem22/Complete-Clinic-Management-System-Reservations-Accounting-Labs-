<?php

$con = mysqli_connect("localhost","root","","najmdb");
	mysqli_set_charset($con,'utf8');

if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

?>
