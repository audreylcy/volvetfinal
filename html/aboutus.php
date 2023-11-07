<?php
// Start the session at the beginning of your script
session_start();

$sessionId = session_id();
require_once 'connection.php';

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
    <title>FAQ Page</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" /> 
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant+Garamond"/>
    <script src="../javascript/faq.js"></script>
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

    <div class="aboutus">
        <h1>ABOUT US</h1>
        <div class="aboutus-container">
            <div class="aboutus-left">
                <img src="../images/aboutus.png">
            </div>
            <div class="aboutus-right">
                <p>At Volvet, we are your premier destination for the exchange of second-hand luxury goods. With a passion for exquisite craftsmanship and timeless elegance, we bring together a community of discerning individuals who appreciate the value of luxury items. Our platform offers a seamless and secure way to buy, sell, or trade pre-owned designer fashion, accessories, watches, and more. Whether you're looking to declutter your collection, find a new treasure, or simply enjoy the sustainable allure of vintage luxury, we provide a trusted marketplace that ensures authenticity and quality. Join us in the world of affordable luxury, where timeless style finds new life.</p>
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
</body>
</html>