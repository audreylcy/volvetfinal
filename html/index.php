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
    <title>Volvet</title>
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

    <div class="home-banner">
        <a href="">
            <img src="../images/home_banner.png">
        </a>
    </div>

    <div class="home-categories">
        <h1>CATEGORIES</h1>
        <div class="categories">
        <div class="category">
            <a href="product.php?categories=Watch">
            <p>Watches</p>
            </a>
            <img src="../images/home_watches.png">
        </div>
        <div class="category">
            <a href="product.php?categories=Bag">
            <p>Bags</p>
            </a>
            <img src="../images/home_bags.png">
        </div>
        <div class="category">
            <a href="product.php?categories=Shoe">
            <p>Shoes</p>
            </a>
            <img src="../images/home_shoes.png">
        </div>
        <div class="category">
            <a href="product.php?categories=Jewellery">
            <p>Jewellery</p>
            </a>
            <img src="../images/home_jewellery.png">
        </div>
        <div class="category">
            <a href="product.php?categories=Accessory">
            <p>Accesories</p>
            </a>
            <img src="../images/home_accessories.png">
        </div>
    </div>
    </div>

    <div class="home-popup">
        <img src="../images/home_popup.png">
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
