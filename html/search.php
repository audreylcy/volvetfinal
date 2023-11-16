<?php
require_once 'connection.php';

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // DB query based on the search 
    $query = "SELECT * FROM products WHERE product_name LIKE '%$searchQuery%'OR category LIKE '%$searchQuery%'";
    $result = $conn->query($query);
    
}


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
<title>Search Results</title>
<link rel="stylesheet" type="text/css" href="../css/style.css" /> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter"/>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cormorant+Garamond"/>
</head>

<body>
        
        <script>
            function productDescription(productId) {
                window.location.href = 'product_description.php?id=' + productId;
            }
    
            //filter scripts 
            function openFilterModal() {
                var modal = document.getElementById('filterModal');
                modal.style.display = 'block';
            }
    
            function closeFilterModal() {
                var modal = document.getElementById('filterModal');
                modal.style.display = 'none';
            }
    
            function filterProducts() {
            var selectedCategories = document.querySelectorAll('input[name="category"]:checked');
            var selectedCategoryValues = Array.from(selectedCategories).map(input => input.value);

            var minPrice = parseFloat(document.getElementById('minPrice').value) || 0;
            var maxPrice = parseFloat(document.getElementById('maxPrice').value) || Number.MAX_VALUE;

            var productCards = document.querySelectorAll('.product-card');
            var noMatchingProducts = true; 

            for (var i = 0; i < productCards.length; i++) {
                var category = productCards[i].getAttribute('data-category');
                var price = parseFloat(productCards[i].getAttribute('data-price'));

                var isCategoryMatch = selectedCategoryValues.length === 0 || selectedCategoryValues.includes(category);
                var isPriceMatch = price >= minPrice && price <= maxPrice;

                if (isCategoryMatch && isPriceMatch) {
                    productCards[i].style.display = 'block';
                    noMatchingProducts = false; 
                } else {
                    productCards[i].style.display = 'none';
                }
            }

            // Display or hide the error message based on the flag
            var errorMessage = document.getElementById('nofiltererror-message');
            if (noMatchingProducts) {
                errorMessage.style.display = 'block'; // Show the error message
            } else {
                errorMessage.style.display = 'none'; // Hide the error message
            }

            closeFilterModal();
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
    
        <div class="product">
            <div class="product-top">
                <h1>SEARCH RESULTS: <?php echo $searchQuery; ?></h1>
                <div class="product-top-right">
                <?php
                if ($result->num_rows > 0) {
                    echo '<span><input type="button" value="Filter" onclick="openFilterModal()"></span>';
                }
                ?>
                </div>
            </div>
            
            <div id="filterModal" class="filtermodal" style="display: none;">
                <div class="modal-content">
                    <div class="filter-content">
                        <div class="category-filter">   
                            <label>Categories</label><br>               
                            <label>
                                <input type="checkbox" name="category" value="Watch"> Watches
                            </label>
                            <label>
                                <input type="checkbox" name="category" value="Bag"> Bags
                            </label>
                            <label>
                                <input type="checkbox" name="category" value="Shoe"> Shoes
                            </label>
                            <label>
                                <input type="checkbox" name="category" value="Jewellery"> Jewellery
                            </label>
                            <label>
                                <input type="checkbox" name="category" value="Accessory"> Accessories
                            </label>
                        </div>
    
                        <div class="price-filter">
                            <label>Price</label><br>
                            <label for="minPrice">Min:</label>
                            <input type="number" id="minPrice" placeholder="Min Price">
                            <label for="maxPrice">Max:</label>
                            <input type="number" id="maxPrice" placeholder="Max Price">
                        </div>
                    </div>
                    <div class="filter-buttons">
                        <input type="button" class="applyfilterButton" value="Apply Filter" onclick="filterProducts()">

                    </div>
                </div>
            </div>
    
            <div id="nofiltererror-message" style="display: none;">
            <p>No products match your filter criteria.</p>
            </div>

            <div class="product-container">
            <?php 
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

                    echo '<div class="product-card" data-category="' . $row['category'] . '" data-price="' . $row['product_price'] . '">';
                    echo '<img src="../images/' . $row['product_image'] . '" alt="' . $row['product_image'] . '" onclick="productDescription(' . $row['id'] . ')">';
                    echo '<h5>' . $row['product_name'] . '</h5>';
                    echo '<h6>$' . $row['product_price'] . '</h6>';
                    echo '</div>';
                }
            } else {

                echo '<p class="nosearchresultsmsg">Sorry, no items were found that matched your search. 
                Please try using more general search terms. You can view all our products in our Shop All tab.</p>';
            }
            ?>
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
                <span class="subscribe-email" ><input type="email" name="subscribe-email" id="subscribe-email" placeholder="Enter your email..."></span>
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