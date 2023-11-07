<?php
// Start the session at the beginning of your script
require_once 'connection.php';
session_start();

$sessionId = session_id();

if (isset($_SESSION['user_email'])){
  $user_email = $_SESSION['user_email'];

  $orderQuery = "SELECT * FROM orders WHERE user_email = '$user_email'";
  $orderResult = $conn-> query($orderQuery);
  $address_id = 0;
  $checkout_id = 0;


  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form values
    $user_email = $_SESSION['user_email'];
    $address1 = $_POST["form-address1"];
    $address2 = $_POST["form-address2"];
    $postalCode = $_POST["form-postal"];
    $state = $_POST["form-state"];
    $shippingMethod = $_POST["form-shipping"];
    $currentDate = date("Y-m-d");
    

    
    $checkAddressQuery = "SELECT * FROM address WHERE user_email = '$user_email' AND address_1 = '$address1' AND address_2 = '$address2' AND postal = '$postalCode' AND state = '$state' AND delivery_method = '$shippingMethod'";
    $addressResult = $conn->query($checkAddressQuery);
    $addressRow = $addressResult -> fetch_assoc();

    if ($addressResult->num_rows === 0) {
        $addressInsertQuery = "INSERT INTO address (user_email, address_1, address_2, postal, state, delivery_method)
                VALUES ('$user_email', '$address1', '$address2', '$postalCode', '$state', '$shippingMethod')";
      $addressResultQuery = $conn->query($addressInsertQuery);
      $address_id = mysqli_insert_id($conn);
    } else {
      $address_id = $addressRow['address_id'];
    }
    


   
    $insertCheckoutQuery = "INSERT INTO checkout_details (user_email, address_id, total_price, created_at) VALUES ('$user_email', '$address_id', {$_SESSION['formattedTotalWithoutComma']}, '$currentDate')";
    $insertCheckoutResult = $conn->query($insertCheckoutQuery);
    $checkout_id = mysqli_insert_id($conn);
    

    while ($orderRow = mysqli_fetch_assoc($orderResult)) {
      $product_id = $orderRow['product_id'];
      $product_price = $orderRow['product_price'];
      $quantity = $orderRow['quantity'];
      $subtotal = $product_price * $quantity;
      $insertOrderDetailsQuery = "INSERT INTO order_details (product_id, quantity, product_price, subtotal, checkout_id) VALUES ('$product_id', '$quantity', '$product_price', '$subtotal', '$checkout_id')";
      $insertOrderDetailResult = $conn->query($insertOrderDetailsQuery);
      
    }
    if ($insertOrderDetailResult) {
      $clearOrderQuery = "DELETE FROM orders WHERE user_email = '{$_SESSION['user_email']}'";
      $clearOrdertResult = $conn-> query($clearOrderQuery); 
    }
    mysqli_data_seek($orderResult, 0);
    header("Location: profile.php");
  }
}

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
        <a class="nav-logo" href="index.php"><img  src="../images/Volvet.png"></a>
        
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
        
        <div class="checkout-left" >
            <h1>Check Out</h1>
            <div class="checkout-address">
                <h3>Address</h3>
                <form class="address-form" method="post">
                    <div class="form-row1">
                      <input type="text" id="form-address1" name="form-address1" placeholder="Address Line 1" required>
                      <span id="addressError" class="error"></span>
                    </div>
                  
                    <div class="form-row2">
                      <input type="text" id="form-address2" name="form-address2" placeholder="Address Line 2" >
                    </div>
                  
                    <div class="form-row3">
                      <input type="number" id="form-postal" name="form-postal" placeholder="Postal Code" required>
                      <input type="text" id="form-state" name="form-state" placeholder="State" required>
                    </div>
                    <div class="form-row3-error">
                      <span id="postalCodeError" class="error"></span>
                      <span id="stateError" class="error"></span>
                    </div>

                  
                    <div class="form-row4">
                      <select id="shippingMethod" name="form-shipping" name="form-shipping">
                        <option value="Standard Shipping">Standard Shipping</option>
                        <option value="Express Shipping">Express Shipping</option>
                      </select>
                    </div>
                    <div class="checkout-button">
                      <button type="submit" id="checkout-button">Checkout</button>
                    </div>
                  </form>
            </div>
            <!-- <div class="checkout-payment">
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
            </div> -->
            
        </div>
        
        
        <div class="checkout-right">
            <h3>Cart Summary</h3>
              
            <?php 
            $total = 0; // Initialize total outside the loop
            $formattedTotal = 0;
            while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                $cartProduct = $orderRow['product_id'];
  
                $productQuery = "SELECT * FROM products WHERE id = $cartProduct";
                $productResult = $conn->query($productQuery);
                $productRow = $productResult->fetch_assoc();
            
                $subtotal = $productRow['product_price'] * $orderRow['quantity'];
                $total += $subtotal;
                $formattedTotal = number_format($total, 2);
                $formattedTotalWithoutComma = str_replace(',', '', $formattedTotal);
                $_SESSION['formattedTotalWithoutComma'] = $formattedTotalWithoutComma;
            ?>
            <div class="checkout-cartsummary-product">
                <div class="checkout-cartsummary-productimg">
                    <img src="../images/<?php echo $productRow["product_image"]?>" >
                </div>
                <div class="checkout-cartsummary-productdesc">
                    <h3><?php echo $productRow["product_name"]; ?></h3>
                    <p style="font-family: 'Cormorant Garmont';">$<?php echo $productRow["product_price"]; ?></p>
                </div>
            </div>
            <?php 
              } ?>
            
            <div class="checkout-cartsummary-totalprice">
                <p id="checkout-cartsummary-totalprice">Total Price: $<?php echo $formattedTotal; ?></p>
            </div>
            
      
              
        </div>
    </div>
      
    <script>
        document.getElementById("form-address1").addEventListener("input", validateAddress1);
        document.getElementById("form-postal").addEventListener("input", validatePostalCode);
        document.getElementById("form-state").addEventListener("input", validateState);

        function validateAddress1() {
            const address1 = document.getElementById("form-address1").value;
            const addressError = document.getElementById("addressError");

            if (!address1) {
                addressError.textContent = "Address Line 1 is required";
            } else {
                addressError.textContent = "";
            }

            checkForm();
        }

        function validatePostalCode() {
    const postalCode = document.getElementById("form-postal").value;
    const postalCodeError = document.getElementById("postalCodeError");

    // Regular expression for a valid postal code (assuming a specific format)
    const postalCodeRegex = /^\d{6}$/;  

    if (!postalCodeRegex.test(postalCode)) {
        postalCodeError.textContent = "Invalid Postal Code";
    } else {
        postalCodeError.textContent = "";
    }

    checkForm();
}

        function validateState() {
            const state = document.getElementById("form-state").value;
            const stateError = document.getElementById("stateError");

            if (!state) {
                stateError.textContent = "State is required";
            } else {
                stateError.textContent = "";
            }

            checkForm();
        }

        function checkForm() {
            // Check if there are any error messages
            const errorMessages = document.querySelectorAll(".error");
            const checkoutButton = document.getElementById("checkout-button");

            // Disable the button if there are error messages
            checkoutButton.disabled = Array.from(errorMessages).some(element => element.textContent !== "");
        }
    </script>
</body>
</html>
