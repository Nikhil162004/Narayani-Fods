<?php

@include 'config2.php';

session_start();


// if we came on this page with having session
if(isset($_SESSION['username'])) {
    
}   


if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = ($_POST['password']);

    $sql = "SELECT * FROM registration WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];

        header("Location: index.php");
    } else {
        echo "<script> alert('Opps, Email or password is Wrong.');</script>"; 
        
    }
}



?>