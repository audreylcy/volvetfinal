<?php 
require_once 'connection.php';
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
session_start();
$sessionId = session_id();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subscribebutton"])) {
    $email = $_POST["subscribe-email"];

    // Check if the email already exists in the database
    $sql = "SELECT * FROM subscribers WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION["subscription_message"] = "You are already subscribed!";
    } else {
        // Insert the new email into the database
        $insertSql = "INSERT INTO subscribers (email) VALUES ('$email')";
        if (mysqli_query($conn, $insertSql)) {
            $_SESSION["subscription_message"] = "You have subscribed to our mailing list!";
        } else {
            $_SESSION["subscription_message"] = "An error occurred. Please try again later.";
        }
    }
}
    
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
    <script>
        //subscribe scripts 
document.addEventListener("DOMContentLoaded", function () {
    // Check if the session variable is set
    if ("subscription_message" in <?php echo json_encode($_SESSION); ?>) {
        // Display the message in the subscription message container
        var subscriptionMessage = <?php echo json_encode($_SESSION["subscription_message"]); ?>;
        var messageContainer = document.getElementById("subscription-message-container");

        if (messageContainer) {
            // Set the message and make the container visible
            messageContainer.innerHTML = subscriptionMessage;
            messageContainer.style.display = "block"; // or "inline", "inline-block", etc. depending on your layout needs

            // Scroll to the position of the message container
            window.scrollTo({
                top: messageContainer.offsetTop,
                behavior: "smooth" // This makes it a smooth scroll; use "auto" for an instant scroll
            });
        }

        // Clear the session variable (if needed)
        <?php unset($_SESSION["subscription_message"]); ?>;
    }
});

                //search scripts
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchInput");
            const searchButton = document.getElementById("searchButton");

            searchInput.addEventListener("input", function() {
                if (searchInput.value.trim() === "") {
                    searchButton.disabled = true;
                } else {
                    searchButton.disabled = false;
                }
            });

            searchButton.addEventListener("click", function() {
                if (searchInput.value.trim() !== "") {
                    document.getElementById("searchForm").submit();
                }
            });
        });

        //subscribe scripts 
        document.addEventListener("DOMContentLoaded", function () {
            // Check if the session variable is set
            if ("subscription_message" in <?php echo json_encode($_SESSION); ?>) {
                // Display the message in the subscription message container
                var subscriptionMessage = <?php echo json_encode($_SESSION["subscription_message"]); ?>;
                var messageContainer = document.getElementById("subscription-message-container");

                if (messageContainer) {
                    // Set the message and make the container visible
                    messageContainer.innerHTML = subscriptionMessage;
                    messageContainer.style.display = "block"; // or "inline", "inline-block", etc. depending on your layout needs

                    // Scroll to the position of the message container
                    window.scrollTo({
                        top: messageContainer.offsetTop,
                        behavior: "smooth" // This makes it a smooth scroll; use "auto" for an instant scroll
                    });
                }

                // Clear the session variable (if needed)
                <?php unset($_SESSION["subscription_message"]); ?>;
            }
        });
    </script>
    <div class="navigation">
        <nav>
            <ul>
                <li><a href="product.php">SHOP ALL</a></li>
                <li><a href="events.php">EVENTS</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </nav>
        <a class="nav-logo" href="index.php"><img  src="../images/Volvet.png"></a>
        
        <div class="right-nav">
            <div class="search-bar">
            <form action="search.php" method="get" id="searchForm" class="search-form">
                <input type="text" name="query" id="searchInput" placeholder="Search">
                <button type="submit" id="searchButton" disabled><img src="../images/icon_search.png"></button>
            </form>
            </div>
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

            // check if user has logged in
            if (isset($_SESSION['user_email'])) {
                $user_email = $_SESSION['user_email'];
                $orderQuery = "SELECT * FROM orders WHERE user_email = '$user_email'";
                $orderResult = $conn-> query($orderQuery);
                
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $productId => $productDetails) {
                        $quantity = $productDetails['quantity'];
                        $productPrice = $productDetails['product_price'];
                    
                        $productQuery = "SELECT * FROM products WHERE id = $productId";
                        $productResult = $conn->query($productQuery);
                        $productRow = $productResult->fetch_assoc();
                    
                        $subtotal = $productPrice * $quantity;
                        $total += $subtotal;
                    
                        // Insert product into the permanent database
                        if ($orderRow['product_id'] == $productId){
                            unset($_SESSION['cart']);
                        } else {
                            $transferItemsQuery = "INSERT INTO orders (user_email, product_id, quantity, total, product_price)
                                                VALUES ('$user_email', '$productId', '$quantity', '$subtotal', '$productPrice')";
                            if ($conn->query($transferItemsQuery) === TRUE) {
                                unset($_SESSION['cart']);
                            }
                        }
                    }
                }
                
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteProduct"])) {
                    $productId = $_POST["productId"];
                    $userEmail = $_SESSION['user_email'];

                    
                    $clearCartQuery = "DELETE FROM orders WHERE product_id = '$productId' AND user_email = '$userEmail'";
                    $clearCartResult = $conn-> query($clearCartQuery);

                    if ($clearCartResult) {
                        echo '<script>alert("deleted");</script>';
                    }
                    
                }

                if ($orderResult->num_rows > 0){
                
        ?>
            <p>Here are your chosen items, all ready to be yours!</p>

            <table class="cart-product">
                <tr class="cart-header">
                    <th></th>
                    <th>Products</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            <?php   while ($orderRow = mysqli_fetch_assoc($orderResult)) {
                    
                    $cartProduct = $orderRow['product_id'];
                    $productQuery = "SELECT * FROM products WHERE id = $cartProduct";
                    $productResult = $conn-> query($productQuery);
                    $productRow = $productResult -> fetch_assoc();

                    $subtotal = $productRow['product_price'] * $orderRow['quantity'];
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
                        <input type="text" name="name" value="<?php echo $orderRow['quantity']; ?>">
                        <!-- <button class="plus-button" type="button" name="button">
                            <img src="../images/plus.png" alt="" />
                        </button> -->
                    </div>
                </td>            
                <td class="cart-product-price">$<?php echo $orderRow['product_price']; ?></td>
                <td class="cart-product-delete"> 
                    <form action="cart.php" method="post">
                        <input type="hidden" name="productId" value="<?php echo $cartProduct; ?>">
                        <button class="delete-button" type="submit" name="deleteProduct">X</button> 
                    </form>
                </td>
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
                <a href="checkout.php"><button class="buy-now-button">Buy Now</button></a>
                <a href="product.php"><button class="continue-shopping-button">Continue Shopping</button></a>
            </div>

            <!-- no items in cart  -->
            <?php } 
            else {
            ?>
                <p>Your cart is empty, start shopping now!</p>
                <div class="cart-buttons">
                <a href="product.php"><button class="continue-shopping-button">Continue Shopping</button></a>                </div>
            <?php
            }
        
            ?>


        <!-- if user has not logged in and using temporary cart  -->
        <?php
            }else 
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteProduct"])) {
                    $productId = $_POST["productId"];
    
                    if (isset($_SESSION['cart'][$productId])) {
                        unset($_SESSION['cart'][$productId]);
                        echo '<script>alert("deleted");</script>';
    
                        if (empty($_SESSION['cart'])) {
            ?>
                        <p>Your cart is empty, start shopping now!</p>
                                <div class="cart-buttons">
                                    <a href="product.php"><button class="continue-shopping-button">Continue Shopping</button></a>
                                </div>
                        <?php exit();
                        }
    
                    }
      
                }
                
        ?>
        <p>Here are your chosen items, all ready to be yours!</p>

        <table class="cart-product">
            <tr class="cart-header">
                <th></th>
                <th>Products</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            <?php   


            foreach ($_SESSION['cart'] as $productId => $productDetails) {
                
                $quantity = $productDetails['quantity'];
                $productPrice = $productDetails['product_price'];
                // Display product information here
                $sql = "SELECT * FROM products WHERE id = $productId";
                $productResult = $conn->query($sql);
                $productRow = $productResult->fetch_assoc();

                $subtotal = $productPrice * $quantity;
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
                    <input type="text" name="name" value="<?php echo $quantity; ?>">
                    <!-- <button class="plus-button" type="button" name="button">
                        <img src="../images/plus.png" alt="" />
                    </button> -->
                </div>
            </td>            
              <td class="cart-product-price">$<?php echo $productPrice; ?></td>
              <td class="cart-product-delete"> 
                    <form action="cart.php" method="post">
                    <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                    <button class="delete-button" type="submit" name="deleteProduct">X</button> 
                    </form>
            </td>
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

            <!-- no items in cart  -->
            <?php } 
            else {
            ?>
                <p>Your cart is empty, start shopping now!</p>
                <div class="cart-buttons">
                    <a href="product.php"><button class="continue-shopping-button">Continue Shopping</button></a>
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
            <form class="subscribe-form" action="" method="post">
                <span class="subscribe-email" ><input type="text" name="subscribe-email" id="subscribe-email" placeholder="Enter your email..."></span>
                <span class="subscribe-submit"><input type="submit" name="subscribebutton" value="Submit"></span>
            </form>
            <div id="subscription-message-container" style="display: none;">
            <p id="subscription-message"></p>
        </div>
        </div>
    </div>
    
    <div class="footer">
        <img src="../images/Volvet.png" class="footer-logo">
        <ul>
            <li><a href="aboutus.php">About Us</a><br></li>
            <li><a href="product.php">Shop ALL</a><br></li>
            <li><a href="faq.php">FAQ</a><br></li>
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