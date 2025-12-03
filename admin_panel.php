<?php
$con = mysqli_connect('localhost','root','','narayanifoods');

$sub_sql = "";
$toDate = $fromDate = "";

/* -------------------- DELETE ORDER -------------------- */
if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($con, "DELETE FROM orders WHERE id='$delete_id'");
    header("Location: admin_panel.php");
    exit();
}

/* -------------------- FILTER ORDERS -------------------- */
if(isset($_POST['submit'])){
    $from = $_POST['from'];
    $fromDate = $from;
    $fromArr = explode("/", $from);
    $from = $fromArr[2].'-'.$fromArr[1].'-'.$fromArr[0]." 00:00:00";

    $to = $_POST['to'];
    $toDate = $to;
    $toArr = explode("/", $to);
    $to = $toArr[2].'-'.$toArr[1].'-'.$toArr[0]." 23:59:59";

    $sub_sql = " where date >= '$from' AND date <= '$to' ";
}

$res = mysqli_query($con, "select * from orders $sub_sql order by id desc");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Panel</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
*{
    margin:0;
    padding:0;
    font-family:'Poppins',sans-serif;
    box-sizing:border-box;
}
body{
    background-image:url('images/background2.jpg');
    background-repeat:no-repeat;
    background-attachment:fixed;
    background-size:100% 100%;
}
.container1{
    width:100%;
    padding:10px 8%;
}

/* NAVBAR */
.navbar{
    padding:15px 30px;
    display:flex;
    align-items:center;
}
nav{
    flex:1;
    text-align:right;
}
nav a{
    text-decoration:none;
    padding:6px 20px;
    color:white;
    font-weight:500;
    font-size:1.1em;
    position:relative;
    transition:.5s;
}
nav a:hover{ color:#0ef; }
nav a span{
    position:absolute;
    top:0; left:0;
    border-bottom:2px solid #0ef;
    width:100%; height:100%;
    border-radius:15px;
    transform:scale(0) translateY(50px);
    opacity:0;
    transition:.5s;
}
nav a:hover span{
    transform:scale(1) translateY(0);
    opacity:1;
}
.logo{ width:150px; }

/* MAIN WHITE BOX */
.container{
    background-color:#ffffff!important;
    border-radius:8px;
    box-shadow:0 4px 10px rgba(0,0,0,0.2);
    padding:30px;
    margin-top:20px;
}

/* FILTER FORM */
.filter-form{
    background:#ffffff;
    padding:20px;
    border-radius:6px;
    display:flex;
    gap:20px;
    justify-content:center;
    align-items:center;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
    margin-bottom:25px;
}
.filter-form label{ font-weight:bold; }
.filter-form input[type="text"]{
    padding:8px 10px;
    width:130px;
    border-radius:4px;
    border:1px solid #aaa;
}
.filter-form input[type="submit"]{
    padding:8px 20px;
    border:none;
    background:#333;
    color:white;
    border-radius:4px;
    cursor:pointer;
    font-weight:600;
}
.filter-form input[type="submit"]:hover{
    background:#0ef;
    color:black;
}

/* TABLE */
.table th{
    background:#333;
    color:white;
}
.table-responsive{ overflow-x:auto; }
.btn-danger{
    padding:5px 10px;
}
</style>
</head>

<body>
<div class="container1">

<!-- NAVBAR -->
<div class="navbar">
    <img src="logos/mainlogo1.png" class="logo">
    <nav>
        <a href="index.html">Log out<span></span></a>
        <a href="admin_panel.php">Orders<span></span></a>
        <a href="feedback.php">Feedback<span></span></a>
    </nav>
</div>

<!-- MAIN BOX -->
<div class="container">

<h2 class="text-center mb-4">Select Date</h2>

<form method="post" class="filter-form">
    <label>From:</label>
    <input type="text" id="from" name="from" value="<?php echo $fromDate ?>" required>

    <label>To:</label>
    <input type="text" id="to" name="to" value="<?php echo $toDate ?>" required>

    <input type="submit" name="submit" value="Filter">
</form>

<?php if(mysqli_num_rows($res)>0){ ?>
<div class="container" style="background:white; width:auto;background-color:bisque;margin-top:20px;">
    <h2 class="text-center mb-4">Orders</h2>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Pmode</th>
                    <th>Products</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while($row=mysqli_fetch_assoc($res)){ ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['pmode']; ?></td>
                    <td><?php echo $row['products']; ?></td>
                    <td><?php echo $row['amount_paid']; ?></td>
                    <td><?php echo $row['date']; ?></td>

                    <!-- DELETE BUTTON -->
                    <td>
                        <a href="admin_panel.php?delete=<?php echo $row['id']; ?>"
                           onclick="return confirm('Delete this order?');"
                           class="btn btn-danger btn-sm">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>

<?php } else { echo "<h3 class='text-center'>No data found</h3>"; } ?>

</div>
</div>

<script>
$(function(){
    var dateFormat = "dd/mm/yy",
    from = $("#from").datepicker({
        changeMonth: true,
        dateFormat: "dd/mm/yy"
    }).on("change", function(){
        to.datepicker("option", "minDate", getDate(this));
    }),
    to = $("#to").datepicker({
        changeMonth: true,
        dateFormat: "dd/mm/yy"
    }).on("change", function(){
        from.datepicker("option", "maxDate", getDate(this));
    });

    function getDate(element){
        try { return $.datepicker.parseDate(dateFormat, element.value); }
        catch { return null; }
    }
});
</script>

</body>
</html>
