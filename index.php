<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
    <link rel="stylesheet" href="styleproducts1.css">
    <style>
        body{
            background-image: url('images/background2.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        /* ------------------ MENU TITLE CSS ------------------ */
        .menu-title {
            text-align: center;
            font-size: 50px;
            margin-top: 30px;
            margin-bottom: 40px;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px black;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
  
<div class="container1">
    <div class="navbar">
        <img src="logos/mainlogo1.png" class="logo">
        <nav>
            <a href="index.html">Home<span></span></a>
            <a href="index.php">Menu<span></span></a>
            <a href="checkout.php">Chechout<span></span></a>
            <a href="cart.php">Cart<span></span></a>
        </nav>
    </div>

    <!-- ===== MENU TITLE ADDED HERE ===== -->
    <h1 class="menu-title">OUR MENU</h1>

    <div class="container">
        <div id="message"></div>
        
        <div class="row mt-2 pb-3">
        <?php
            include 'config.php';
            $stmt = $conn->prepare('SELECT * FROM product');
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()):
        ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
            <div class="card-deck">
            <div class="card p-2 border-secondary mb-2">
                <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250">
                <div class="card-body p-1">
                <h4 class="card-title text-center text-info"><?= $row['product_name'] ?></h4>
                <h5 class="card-text text-center text-danger"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?>/-</h5>
                </div>
                <div class="card-footer p-1">
                <form action="" class="form-submit">
                    <div class="row p-2">
                    <div class="col-md-6 py-1 pl-4">
                        <b>Quantity : </b>
                    </div>
                    <div class="col-md-6">
                      <input type="number" class="form-control pqty" value="1" min="1">

                    </div>
                    </div>
                    <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                    <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                    <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                    <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                    <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                    <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to cart</button>
                </form>
                </div>
            </div>
            </div>
        </div>
        <?php endwhile; ?>
        </div>
    </div>
</div>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

<script type="text/javascript">
$(document).ready(function() {

  // Prevent quantity from going below 1
  $(".pqty").on("input", function () {
    if ($(this).val() <= 0) {
        $(this).val(1);
    }
  });

  $(".addItemBtn").click(function(e) {
    e.preventDefault();
    var $form = $(this).closest(".form-submit");

    var pid = $form.find(".pid").val();
    var pname = $form.find(".pname").val();
    var pprice = $form.find(".pprice").val();
    var pimage = $form.find(".pimage").val();
    var pcode = $form.find(".pcode").val();
    var pqty = $form.find(".pqty").val();

    $.ajax({
      url: 'action.php',
      method: 'post',
      data: { pid: pid, pname: pname, pprice: pprice, pqty: pqty, pimage: pimage, pcode: pcode },
      success: function(response) {
        $("#message").html(response);
        window.scrollTo(0, 0);
        load_cart_item_number();
      }
    });
  });

  load_cart_item_number();

  function load_cart_item_number() {
    $.ajax({
      url: 'action.php',
      method: 'get',
      data: { cartItem: "cart_item" },
      success: function(response) {
        $("#cart-item").html(response);
      }
    });
  }

});
</script>


</body>
</html>
