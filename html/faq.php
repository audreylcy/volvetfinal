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
    <title>FAQ Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" /> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant+Garamond"/>
    <script src="../javascript/faq.js"></script>
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

    <div class="faq">
        <h1>FAQ</h1>
        <div class="faq-container">
            <div class="faq-label">How much is shipping?</div>
            <div class="faq-content">
                <p>Shipping costs vary depending on your location and the shipping method you choose during the checkout process. You can view the shipping options and their respective costs before finalizing your order.
                </p>
            </div>
        </div>
        <div class="faq-container">
            <div class="faq-label">How long does delivery take?</div>
            <div class="faq-content">
                <p>The delivery time also depends on your location and the shipping method you select. Standard shipping typically takes a few business days, while expedited shipping may be faster. You will receive an estimated delivery date when you place your order.
                </p>
            </div>
        </div>
        <div class="faq-container">
            <div class="faq-label">Where do we deliver to?</div>
            <div class="faq-content">
                <p>We offer worldwide shipping to a wide range of destinations. During the checkout process, you can enter your address to confirm if we deliver to your location.
                </p>
            </div>
        </div>
        <div class="faq-container">
            <div class="faq-label">Can I refund/exchange my items?</div>
            <div class="faq-content">
                <p>Yes, we have a return and exchange policy. If you are not satisfied with your purchase, you can request a refund or exchange within a specified period, typically within 30 days of receiving your order. Please review our detailed return and exchange policy on our website for more information.
                </p>
            </div>
        </div>
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
                <span class="subscribe-email" ><input type="text" placeholder="Enter your email..." required></span>
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
</body>
</html>