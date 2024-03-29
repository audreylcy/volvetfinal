<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$sessionId = session_id();
require 'connection.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php?error=notloggedin');
    exit();
}

$user_email = $_SESSION['user_email'];

//fetch user info
$sql = "SELECT email, dob FROM users WHERE email = '$user_email'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // fetch userinfo
    $userData = $result->fetch_assoc();
} else {
    // data not found
    die("User not found");
}

$addressQuery = "SELECT * FROM address WHERE user_email = '$user_email'";
$addressResult = $conn -> query($addressQuery);
$addressRow = $addressResult->fetch_assoc();

$checkoutQuery = "SELECT * FROM checkout_details WHERE user_email = '$user_email'";
$checkoutResult = $conn -> query($checkoutQuery);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" /> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant+Garamond"/>
</head>
<body>
    <script>
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
            <a href="profile.php"><img src="../images/icon_profile.png"></a>
            <a href="cart.php"><img src="../images/icon_cart.png"></a>
        </div>
    </div>

    <div class="profile-account">
        <h1>ACCOUNT</h1>

        <div class="profile-top">
            <div class="profile-account-info">
                <h3>Account Information</h3>
                <p><b>Name:</b> <?php echo $userData['email']; ?></p>
                <p><b>DOB:</b> <?php echo $userData['dob']; ?></p>
            </div>
            <div class="profile-address">
                <h3>Addresses</h3>
                <?php
                    if ($addressResult->num_rows > 0){
                ?>
                    <p id="address_1"><?php echo $addressRow['address_1']?></p>
                    <p id="address_2"><?php echo $addressRow['address_2']?></p>
                    <p id="postal"><?php echo $addressRow['postal']?></p>
                    <p id="state"><?php echo $addressRow['state']?></p>
                <?php
                } else {
                ?>
                    <p><?php echo "Address not found"; ?></p>
                <?php
                }
                ?>
            </div>
        </div>

        <!-- <div class="profile-bottom">
            <h3>Reward Points</h3>
            <p>232</p>
            <p>Expiring on: 2/3/2023</p>
        </div> -->

        <div class="profile-order-history">
            <h3>Order History</h3>
        <table class="profile-order-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Order</th>
                <th>Shipping Method</th>
                <th>Items</th>
                <th>Total</th>
              </tr>
            </thead>
            <?php 
                while ($checkoutRow = mysqli_fetch_assoc($checkoutResult)) {
                    $checkout_id = $checkoutRow['checkout_id'];
                    $orderDetailsQuery = "SELECT * FROM order_details WHERE checkout_id = '$checkout_id'";
                    $orderDetailsResult = $conn -> query($orderDetailsQuery);
                    if($orderDetailsResult->num_rows > 0) {

            ?>
            <tbody>
              <tr class="profile-order-details" >
                    <td rowspan="<?php echo mysqli_num_rows($orderDetailsResult); ?>"><?php echo $checkoutRow['created_at']; ?></td>
                    <td rowspan="<?php echo mysqli_num_rows($orderDetailsResult); ?>">#<?php echo $checkoutRow['checkout_id']; ?></td>
                    <td rowspan="<?php echo mysqli_num_rows($orderDetailsResult); ?>"><?php echo $addressRow['delivery_method']; ?></td>
                <?php
                while ($orderDetailsRow = mysqli_fetch_assoc($orderDetailsResult)){ 
                    $orderProductId = $orderDetailsRow['product_id'];
                    $productQuery = "SELECT * FROM products WHERE id = '$orderProductId'";
                    $productResult = $conn -> query($productQuery);
                    $productRow = $productResult -> fetch_assoc();
                ?>
                
                <td class="product-id-column"><?php echo $productRow['product_name']; ?></td>
                <?php
                    }
                ?>
                <td class="product-price-column">$<?php echo $checkoutRow['total_price']; ?></td>
            
                    
              </tr>
            </tbody>
            <?php 
                }
            }
            ?>
          </table>
          <form action="logout.php" class="profile-logout" method="post">
            <input class="logout-button" type="submit" value="Logout">
          </form>
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
    
<style>
  

  .product-id-column {
    flex: 1;
    height: 50px; /* Set a fixed height for each row */
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    text-align: center;
  }
</style>
</body>
                
</html>


