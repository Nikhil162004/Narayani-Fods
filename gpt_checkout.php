<?php
	require 'config.php';

	$grand_total = 0;
	$allItems = '';
	$items = [];

	$sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($row = $result->fetch_assoc()) {
	  $grand_total += $row['total_price'];
	  $items[] = $row['ItemQty'];
	}
	$allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
    /* Reset default browser styles */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f8f8f8;
    color: #333;
    font-size: 16px;
}

.container1 {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

nav {
    background-color: #fff;
    padding: 15px 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logo {
    height: 40px;
}

ul {
    list-style-type: none;
    display: flex;
}

ul li {
    margin-right: 25px;
}

ul li a {
    text-decoration: none;
    color: #333;
    font-size: 18px;
    transition: color 0.3s ease;
}

ul li a:hover {
    color: #ff6347; /* Tomato red */
}

.container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-top: 30px;
}

.form-group {
    margin-bottom: 30px;
}

.form-control {
    width: 100%;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 8px;
    transition: border-color 0.3s ease;
    font-size: 18px;
}

.form-control:focus {
    border-color: #ff6347; /* Tomato red */
}

.btn-block {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 8px;
    background-color: #ff6347; /* Tomato red */
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 20px;
}

.btn-block:hover {
    background-color: #e74c3c; /* Darker red on hover */
}

.jumbotron {
    background-color: #f0f0f0;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 30px;
}

@media (max-width: 768px) {
    nav {
        padding: 10px;
    }

    ul {
        flex-direction: column;
    }

    ul li {
        margin-bottom: 20px;
    }

    .logo {
        height: 30px;
    }

    .form-control {
        padding: 12px;
        font-size: 16px;
    }

    .btn-block {
        padding: 12px;
        font-size: 18px;
    }
}
    </style>
  
</head>
<body>
<div class="container1">
    <nav>
        <img src="logos/mainlogo1.png" class="logo">
        <ul>
            <li><a href="index.html">Logout</a></li>
            <li><a href="index.php">Menu</a></li>
            <li><a href="checkout.php">Checkout</a></li>
            <li><a href="cart.php">Cart</a></li>
        </ul>
    </nav>
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 pb-4" id="order">
        <h4 class="text-center text-info p-2">Complete your order!</h4>
        <div class="jumbotron p-3 mb-2 text-center">
          <h6 class="lead"><b>Product(s) : </b><?= $allItems; ?></h6>
          <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
          <h5><b>Total Amount Payable : </b><?= number_format($grand_total,2) ?>/-</h5>
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
            <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead">Select Payment Mode</h6>
          <div class="form-group">
            <select name="pmode" class="form-control" >
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod">Cash On Delivery</option>
              <option value="netbanking">Net Banking(not available)</option>
              <option value="cards">Debit/Credit Card(not available)</option>
            </select>
          </div>
          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block">
          </div>
        </form>
      </div>
    </div>
  

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Sending Form data to the server
    $("#placeOrder").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>

</body>

</html>