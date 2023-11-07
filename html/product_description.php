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
        $quantity = 1; // Default quantity is 1

        $sql = "SELECT * FROM products WHERE id = $productId";
        $productResult = $conn->query($sql);
        $productRow = $productResult->fetch_assoc();
        $productPrice = $productRow['product_price'];

        
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

        

        
        // $sessionId = session_id();
        // $_SESSION['sessionId'] = $sessionId;
        // $productId = $_POST['product_id'];
        // $quantity = 1; 
        // $totalPrice = 0;

        // $checkCartQuery = "SELECT * FROM cart WHERE session_id = '$sessionId' AND product_id = $productId";
        // $checkCartResult = $conn->query($checkCartQuery);

        // if ($checkCartResult->num_rows > 0) {
        //     echo '<script>alert("Product already added to cart!");</script>';
        // } else {
        //     $sql = "SELECT * FROM products WHERE id = $productId";
        //     $productResult = $conn->query($sql);
        //     $productRow = $productResult->fetch_assoc();

        //     $total = $quantity * $productRow['product_price'];
        //     $insertCartQuery = "INSERT INTO cart (session_id, product_id, quantity, total, product_price) VALUES ('$sessionId', {$productRow['id']}, $quantity, $total, {$productRow['product_price']})";
        //     if ($conn->query($insertCartQuery) === TRUE) {
        //         echo '<script>alert("Product added to cart!");</script>';
        //     } else {
        //         echo "Error: " . $insertCartQuery . "<br>" . $conn->error;
        //     }
        // }
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
        // JavaScript function to redirect to a new page
        function productDescription(productId) {
            // Replace 'newpage.html' with the URL of the page you want to redirect to
            window.location.href = 'product_description.php?id=' + productId;
        }

        if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
        }
    </script>

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

    <div class="product-description">
        <div class="product-deescription-top">
            <?php
                if($row = mysqli_fetch_assoc($result)) {
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
                    <p>Quantity: 1</p>
                    <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                    <span><input name="buy_now" type="submit" value="Buy Now"></span>
                    
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

</body>
</html>