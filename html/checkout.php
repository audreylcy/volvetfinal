<?php
// Start the session at the beginning of your script
session_start();

$sessionId = session_id();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" /> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant+Garamond"/>
</head>
<body>
    <div class="navigation">
        <nav>
            <ul>
                <li><a href="product.php">SHOP ALL</a></li>
                <li><a href="sale.html">SALE</a></li>
                <li><a href="event.html">EVENTS</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </nav>
        <div class="nav-logo-container">
            <img class="nav-logo" src="../images/Volvet.png">
        </div>
        
        <div class="right-nav">
            <img src="../images/icon_search.png">
            <?php
            if (isset($_SESSION['user_email'])) {
                // If the user is logged in, display the profile link
                echo '<a href="profile.php"><img src="../images/icon_profile.png"></a>';
            } else {
                // If the user is not logged in, display a login link
                echo '<a href="login.php"><img src="../images/icon_profile.png"></a>';
            }
            ?>
            <a href="cart.php"><img src="../images/icon_cart.png"></a>
        </div>
    </div>

    <div class="checkout">
        
        <div class="checkout-left">
            <h1>Check Out</h1>
            <div class="checkout-address">
                <h3>Address</h3>
                <form class="address-form">
                    <div class="form-row1">
                      <input type="text" id="form-address1" placeholder="Address Line 1" required>
                    </div>
                  
                    <div class="form-row2">
                      <input type="text" id="form-address2" placeholder="Address Line 2" required>
                    </div>
                  
                    <div class="form-row3">
                      <input type="number" id="form-postal" placeholder="Postal Code" required>
                      <input type="text" id="form-state" placeholder="State" required>
                    </div>
                  
                    <div class="form-row4">
                      <select id="shippingMethod" name="form-shipping">
                        <option value="standard">Standard Shipping</option>
                        <option value="express">Express Shipping</option>
                      </select>
                    </div>
                  </form>
            </div>
            <div class="checkout-payment">
                <h3>Payment</h3>
                <div class="form-payment">
                    <div class="payment-option">
                      <input type="radio" id="visa-option" name="payment-method" value="visa">
                      <label for="visa-option">Visa</label>
                      <div class="visa-img">
                        <img src="../images/visa.png" alt="PayNow QR Code" class="payment-qr-code">
                      </div>
                    </div>
                  
                    <div class="payment-option">
                      <input type="radio" id="paynow-option" name="payment-method" value="paynow">
                      <label for="paynow-option">PayNow</label>
                      <div class="paynow-img">
                      <img src="../images/qrcode.png" alt="PayNow QR Code" class="payment-qr-code">
                      </div>
                    </div>
                  </div>              
            </div>
            <div class="checkout-button">
                <button id="checkout-button">Checkout</button>
            </div>
        </div>

        <div class="checkout-right">
            <h3>Cart Summary</h3>
                <div class="checkout-cartsummary-product">
                    <div class="checkout-cartsummary-productimg">
                        <img src="../images/cart_product.png">
                    </div>
                    <div class="checkout-cartsummary-productdesc">
                        <h3>Cartier Necklace</h3>
                        <p>Exquisite, handcrafted necklace adorned with dazzling gemstones, a symbol of timeless elegance and a perfect statement piece for any occasion.</p>
                    </div>
                </div>
                <div class="checkout-cartsummary-product">
                  <div class="checkout-cartsummary-productimg">
                      <img src="../images/cart_product.png">
                  </div>
                  <div class="checkout-cartsummary-productdesc">
                      <h3>Cartier Necklace</h3>
                      <p>Exquisite, handcrafted necklace adorned with dazzling gemstones, a symbol of timeless elegance and a perfect statement piece for any occasion.</p>
                  </div>
              </div>
              <div class="checkout-cartsummary-totalprice">
                <p id="checkout-cartsummary-totalprice">Total Price: $4502</p>
              </div>
        </div>
    </div> 