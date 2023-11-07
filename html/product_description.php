<?php 

require_once 'connection.php';
session_start();
if(isset($_GET['id'])) {
    $productId = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = mysqli_query($conn, $query);
}

$query = "SELECT * FROM products ORDER BY RAND() LIMIT 4"; // Order the results randomly
$viewproduct = mysqli_query($conn, $query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["buy_now"])) {
    if (isset($_SESSION['user_email'])) {
        $user_email = $_SESSION['user_email'];
        $productId = $_POST['product_id'];
        $quantity = 1; 
        $totalPrice = 0;

        $checkOrderQuery = "SELECT * FROM orders WHERE user_email = '$user_email' AND product_id = $productId";
        $checkOrderResult = $conn->query($checkOrderQuery);
        
        if ($checkOrderResult->num_rows > 0) {
            echo '<script>alert("Product already added to cart!");</script>';
        } else {
            $sql = "SELECT * FROM products WHERE id = $productId";
            $productResult = $conn->query($sql);
            $productRow = $productResult->fetch_assoc();
            
            $total = $quantity * $productRow['product_price'];
            $insertOrderQuery = "INSERT INTO orders (user_email, product_id, quantity, total, product_price) VALUES ('$user_email', {$productRow['id']}, '$quantity', '$total', {$productRow['product_price']})";

            if ($conn->query($insertOrderQuery) === TRUE) {
                echo '<script>alert("Product added to cart!");</script>';
            } else {
                echo "Error: " . $insertOrderQuery . "<br>" . $conn->error;
            }
        }
    }
    else {

        $productId = $_POST['product_id'];

        $sql = "SELECT * FROM products WHERE id = $productId";
        $productResult = $conn->query($sql);
        $productRow = $productResult->fetch_assoc();
        $productPrice = $productRow['product_price'];
        $quantity = $productRow['product_quantity'];

        
        // Check if the cart array exists in the session
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array(); // Initialize the cart as an empty array if it doesn't exist
        }

        // Check if the product is already in the cart
        if (array_key_exists($productId, $_SESSION['cart'])) {
            echo '<script>alert("Product already added to cart!heyyyyy");</script>'; 

        } else {
            $_SESSION['cart'][$productId] = array(
                'quantity' => $quantity,
                'product_price' => $productPrice);
            echo '<script>alert("Product added to cart!helllloooo");</script>';
        }

        // Check if the cart array exists in the session
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productId => $productDetails) {

                // Retrieve the product details from the database using $productId
                $sql = "SELECT * FROM products WHERE id = $productId";
                $productResult = $conn->query($sql);
                $productRow = $productResult->fetch_assoc();
                $productPrice = $productRow['product_price'];

                echo "Product ID: $productId, Quantity: $quantity, Price: $productPrice<br>";
            }
        } else {
            echo "Your cart is empty.";
        }


    }
     
}

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

        // JavaScript function to redirect to a new page
        function productDescription(productId) {
            // Replace 'newpage.html' with the URL of the page you want to redirect to
            window.location.href = 'product_description.php?id=' + productId;
        }

        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }

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
                <li><a href="event.html">EVENTS</a></li>
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

    <div class="product-description">
        <div class="product-deescription-top">
            <?php
                if($row = mysqli_fetch_assoc($result)) {
                    $quantity = $row['product_quantity'];
            ?>
            <div class="description-left">
                <img class="main" src="../images/<?php echo $row["product_image"]?>">
                <div class="description-image">
                    <img src="../images/<?php echo $row["description_image2"]?>">
                    <img src="../images/<?php echo $row["description_image1"]?>">
                </div>
            </div>
            <form class="description-right" method="post">
                <div class="description-title" >
                    <h2><?php echo $row["product_name"]?></h2>
                    <h7 class="description-price" name="product_price" >$<?php echo $row["product_price"]?></h7>
                    <p>Quantity: <?php echo $row["product_quantity"]?></p>
                    <?php
                        if($quantity > 0) {
                    ?>
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <span><input name="buy_now" type="submit" value="Buy Now"></span>
                    <?php
                        }else {

                    ?>
                        <span><input name="sold_out" type="button" value="Sold Out"></span>
                    <?php
                        }?>
                </div>
                <div class="description-details">
                    <h3>DETAILS</h3>
                    <p><?php echo $row["product_description"]?></p>
                </div>
                <div class="description-sizing">
                    <h3>SIZING</h3>
                    <ul>
                        <li><?php echo $row["product_size"]?></li>
                    </ul>
                </div>
                <?php
                }
                ?>
            </form>
        </div>
        
        <div class="description-more">
            <h3>OTHERS ALSO VIEWED</h3>
            
            <div class="description-more-container">
            <?php
                while($row = mysqli_fetch_assoc($viewproduct)) {
                    $viewId = $row['id']

            ?>
                <div class="description-more-card">
                    <img src="../images/<?php echo $row["product_image"]?>" alt="<?php echo $row["product_image"]?>" onclick="productDescription(<?php echo $viewId; ?>)">
                    <h8><?php echo $row["product_name"]?></h8>
                </div>
                <?php
                }
            ?>
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

</body>
</html>