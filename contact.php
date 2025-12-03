<?php

	$email = $_POST['email'];
	$message = $_POST['message'];


	// Database connection
	$conn = new mysqli('localhost','root','','narayanifoods');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into feedback( email, message) values(?, ?)");
		$stmt->bind_param("ss", $email, $message);
		$execval = $stmt->execute();

		header("Location: contact2.html");
		echo "<script> alert('Your Feedback was succesfully submited.');</script>";

		
		$stmt->close();
		$conn->close();
	}
?>