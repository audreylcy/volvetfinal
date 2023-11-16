<?php
require_once 'connection.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$sessionId = session_id();

//subscribe check useremail
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subscribebutton"])) {
    $email = $_POST["subscribe-email"];

    // check email in db
    $sql = "SELECT * FROM subscribers WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION["subscription_message"] = "You are already subscribed!";
    } else {
        // insert email
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
    <title>Volvet</title>
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

        //subscribe scripts 
        document.addEventListener("DOMContentLoaded", function () {
            if ("subscription_message" in <?php echo json_encode($_SESSION); ?>) {
                var subscriptionMessage = <?php echo json_encode($_SESSION["subscription_message"]); ?>;
                var messageContainer = document.getElementById("subscription-message-container");

                if (messageContainer) {
                    // container visible
                    messageContainer.innerHTML = subscriptionMessage;
                    messageContainer.style.display = "block"; 

                    // scroll to position of the message container
                    window.scrollTo({
                        top: messageContainer.offsetTop,
                        behavior: "smooth" 
                    });
                }

                // clear the session variable 
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

                echo '<a href="profile.php"><img src="../images/icon_profile.png"></a>';
            } else {

                echo '<a href="login.php"><img src="../images/icon_profile.png"></a>';
            }
            ?>
            <a href="cart.php"><img src="../images/icon_cart.png"></a>
        </div>
    </div>

    <div class="home-banner">
        <a href="product.php">
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
        <a href="events.php">
        <img src="../images/home_popup.png">
        </a>
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
                <span class="subscribe-email" ><input type="email" name="subscribe-email" id="subscribe-email" placeholder="Enter your email..."></span>
                <span class="subscribe-submit"><input type="submit" value="submit"></span>
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
