<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$sessionId = session_id();
require 'connection.php';

if (!isset($_SESSION['user_email'])) {
    header('Location: login.html?error=notloggedin');
    exit();
}

$user_email = $_SESSION['user_email'];

// Create an SQL query to fetch user information
$sql = "SELECT email, dob FROM users WHERE email = '$user_email'";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the user's information
    $userData = $result->fetch_assoc();
} else {
    // Handle the case where the user's data is not found
    die("User not found");
}
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
    <div>   
        <p>Session ID: <?php echo $sessionId; ?></p>
    </div>
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
            <a href="profile.php"><img src="../images/icon_profile.png"></a>
            <a href="cart.php"><img src="../images/icon_cart.png"></a>
        </div>
    </div>

    <div class="profile-account">
        <h1>ACCOUNT</h1>

        <div class="profile-top">
            <div class="profile-account-info">
                <h3>Account Information</h3>
                <p>Name: <?php echo $userData['email']; ?></p>
                <p>DOB: <?php echo $userData['dob']; ?></p>
            </div>
            <div class="profile-address">
                <h3>Addresses</h3>
                <p id="billing-address">Billing Address: ABC Street</p>
                <p id="shipping-address">Shipping Address: DEF Street</p>
            </div>
        </div>

        <div class="profile-bottom">
            <h3>Reward Points</h3>
            <p>232</p>
            <p>Expiring on: 2/3/2023</p>
        </div>

        <div class="profile-order-history">
            <h3>Order History</h3>
        <table class="profile-order-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Order</th>
                <th>Order Status</th>
                <th>Items</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td id="order-history-date">2023/10/17</td>
                <td id="order-history-date">#12345</td>
                <td id="order-history-date">Payment Received</td>
                <td id="order-history-date">LV Vintage Bag <br> Dior Saddle Bag</td>
                <td id="order-history-date">SGD $200</td>
              </tr>
              <tr>
                <td id="order-history-date">2023/10/16</td>
                <td id="order-history-date">#12344</td>
                <td id="order-history-date">Payment Received</td>
                <td id="order-history-date">LV Vintage Bag <br> Dior Saddle Bag</td>
                <td id="order-history-date">SGD $350</td>
              </tr>
            </tbody>
          </table>
          <form action="logout.php" class="profile-logout" method="post">
            <input type="submit" value="Logout">
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


