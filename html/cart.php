<?php 
require_once 'connection.php';
    session_start();
    $sessionId = session_id();
    echo $sessionId;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
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

    <div class="cart-content">
        <h1>CART SUMMARY</h1>
        
        <?php 
            $total = 0;
            $sessionQuery = "SELECT * FROM cart WHERE session_id = '$sessionId'";
            $sessionResult = $conn-> query($sessionQuery);
            if (isset($_SESSION['user_email']) && $sessionResult->num_rows > 0) {
                $user_email = $_SESSION['user_email'];
                $transferItemsQuery = "INSERT INTO orders (user_email, product_id, quantity, total, product_price) 
                              SELECT '$user_email', product_id, quantity, total, product_price
                              FROM cart
                              WHERE session_id = '$sessionId'";
                $transferItemsResult = $conn-> query($transferItemsQuery); 
                
            }else {
                
                
            }
            if ($sessionResult->num_rows > 0){
            
        ?>
        <p>Here are your chosen items, all ready to be yours!</p>

        <table class="cart-product">
            <tr class="cart-header">
                <th></th>
                <th>Products</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        <?php   while ($sessionRow = mysqli_fetch_assoc($sessionResult)) {
                
                $cartProduct = $sessionRow['product_id'];
                $productQuery = "SELECT * FROM products WHERE id = $cartProduct";
                $productResult = $conn-> query($productQuery);
                $productRow = $productResult -> fetch_assoc();

                $subtotal = $productRow['product_price'] * $sessionRow['quantity'];
                $total += $subtotal;
                $formattedTotal = number_format($total, 2);

        ?>
            <tr>
              <td>
                <img src="../images/<?php echo $productRow["product_image"]?>" class="cart-product-img">
              </td>
              <td class="cart-product-info">
                <h3 id="cart-product-title"><?php echo $productRow["product_name"]?></h3>
                <p id="cart-product-desc"><?php echo $productRow["product_size"]?></p>
              </td>
              <td class="cart-product-quantity">
                <div class="cart-quantity-buttons">
                    <!-- <button class="minus-button" type="button" name="button">
                        <img src="../images/minus.png" alt="" />
                    </button> -->
                    <input type="text" name="name" value="<?php echo $sessionRow['quantity']; ?>">
                    <!-- <button class="plus-button" type="button" name="button">
                        <img src="../images/plus.png" alt="" />
                    </button> -->
                </div>
            </td>            
              <td class="cart-product-price">$<?php echo $sessionRow['product_price']; ?></td>
            </tr>
            <?php  }
            ?>
            <tr class="cart-total">
                <td></td>
                <td></td>
                <td>Total</td>
                <td>$<?php echo $formattedTotal; ?></td>
            </tr>
        </table>
            <div class="cart-buttons">
            <?php
            if (isset($_SESSION['user_email'])) {
                // If the user is logged in, display the "Buy Now" button with a link to checkout.php
                echo '<a href="checkout.php"><button class="buy-now-button">Buy Now</button></a>';
            } else {
                // If the user is not logged in, display the "Buy Now" button with a link to the login page
                echo '<a href="login.php"><button class="buy-now-button">Buy Now</button></a>';
            }
            ?>
                <a href="product.php"><button class="continue-shopping-button">Continue Shopping</button></a>
            </div>
            <?php } 
            else {
            ?>
                <p>Your cart is empty, start shopping now!</p>
                <div class="cart-buttons">
                    <button class="continue-shopping-button">Continue Shopping</button>
                </div>
            <?php
            }
            ?>
            
        
        
        

        
    </div>

    <div class="subscribe">
        <div class="subscribe-left">
            <img src="../images/footer.png">
        </div>
        <div class="subscribe-right">
            <h4>
                Get Social!
            </h4>
            <p>Discover Luxury, Renewed: Subscribe to Our Newsletter for Exclusive Updates on Second-Hand Designer Finds. </p>
            <form class="subscribe-form">
                <span class="subscribe-email" ><input type="text" placeholder="Enter your email..."></span>
                <span class="subscribe-submit"><input type="submit"  value="submit"></span>
            </form>
        </div>
    </div>
    
    <div class="footer">
        <img src="../images/Volvet.png" class="footer-logo">
        <ul>
            <li><a>About Us</a><br></li>
            <li><a>Shop ALL</a><br></li>
            <li><a>FAQ</a><br></li>
        </ul>
        <div class="footer-social">
            <img src="../images/icon_instagram.png">
            <img src="../images/icon_facebook.png">
            <img src="../images/icon_tiktok.png">
            <img src="../images/icon_twitter.png">
        </div>
        <p class="footer-email">contactus@volvet.com</p>
        <p> <small>©2023 Volvet All Rights Reserved.</small> </p>
    </div>
