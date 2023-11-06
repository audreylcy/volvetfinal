<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

$sessionId = session_id();

// Include your database connection code here
require 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
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
            <a href="login.php"><img src="../images/icon_profile.png"></a>
            <a href="cart.php"><img src="../images/icon_cart.png"></a>
        </div>
    </div>

    <div class="login">
        <div>
            <h1>LOGIN</h1>
            <p>Access your account</p>
            <form class="form" action="login_process.php" method="post">
                <span class="text-input">
                    <input id="email" type="text" name="email" placeholder="Email" required>
                    <span id="emailError" class="error"></span>

                    <input type="password" name="password" placeholder="Password" required>
                </span>
                <span class="buttons">
                    <input class="login-button" type="submit" value="Login">
                </span>
            </form>
            <input class="login-signup" type="button" value="Sign Up" onclick="window.location.href='signup.php'">
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

    <script>
        document.getElementById("email").addEventListener("input", validateEmail);

        function emailIsValid(email) {
            // Basic email format validation
            return /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/.test(email);
        }

        function validateEmail() {
            const email = document.getElementById("email").value;
            const emailError = document.getElementById("emailError");

            if (!emailIsValid(email)) {
                emailError.textContent = "Invalid Email Address";
            } else {
                emailError.textContent = "";
            }
        }
    </script>
</body>
</html>