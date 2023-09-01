<?php
	$conn = mysqli_connect("localhost","root","","ngo");
	if (!$conn) 
	{
		die("Connection failed: " . mysqli_connect_error());
	}
	echo "Connected successfully";
	$fname="James";
	$lname="Charles";
	$username="d_james";
	$userid=1933;
	$phone=1233267891;
	$password="james";
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	
	$temp = mysqli_query($conn,"INSERT INTO `driver_det` VALUES (' {$fname}', '{$lname}', '{$username}', '{$password_hash}','$phone','$userid')");
	

?>