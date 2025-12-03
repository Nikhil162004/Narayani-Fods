<?php
	$name     = $_POST['name'];
	$username = $_POST['username'];
	$email    = $_POST['email'];
	$password = $_POST['password'];
	$phone    = $_POST['phone'];
	$address  = $_POST['address'];

	$conn = new mysqli('localhost','root','','narayanifoods');
	if($conn->connect_error){
		echo "$conn->connect_error";
		die("Connection Failed : ". $conn->connect_error);
	} else {
		$stmt = $conn->prepare("insert into registration(name, username, email, password, phone, address) values(?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssis", $name, $username, $email, $password, $phone,$address);
		$execval = $stmt->execute();
		
		header("Location: login.html");
		echo "<script> alert('Opps, Email or password is Wrong.');</script>"; 

		
		$stmt->close();
		$conn->close();
	}
?>