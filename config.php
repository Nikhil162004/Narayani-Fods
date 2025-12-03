<?php
	$conn = new mysqli("localhost","root","","narayanifoods");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
?>