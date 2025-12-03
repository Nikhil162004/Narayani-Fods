<?php
// session_start();

// if (!isset($_SESSION["admin_id"])) {
//     // Redirect to admin login if not logged in
//     header("Location: admin_panel.php");
//     exit();
// }

// Connect to the database (replace these values with your actual database credentials)
$server = "localhost";
$user  = "root";
$pass = "";
$database = "narayanifoods";

$conn = new mysqli("localhost","root","","narayanifoods");
	if($conn->connect_error){
		die("Connection Failed!".$conn->connect_error);
	}
echo "";


// Retrieve contact messages from the database
$sql = "SELECT * FROM feedback ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="stylelogin11.css">
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
           body{
            background-image: url('images/background2.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        .container {
    background-color: #ffffffff;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.table th,
.table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.table th {
    background-color: #333;
    color: #fff;
    text-transform: uppercase;
    font-size: 14px;
}

.table td {
    font-size: 14px;
}

.table-striped tbody tr:nth-child(odd) {
    background-color: #f9f9f9;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
    transition: background-color 0.2s ease-in-out;
}
    </style>
</head>
<body>
<div class="container1">
     <div class="navbar">
    <img src="logos/mainlogo1.png" class="logo">
    <nav>
        
            <a href="index.html">Log out<span></span></a>
            <a href="admin_panel.php">Order<span></span></a>
            <a href="feedback.php">feedback<span></span></a>
        
    </nav>
</div>


    <div class="container mt-5">
        <h2 class="text-center mb-4">Feedbacks</h2>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            
                   
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No messages found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>