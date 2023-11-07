<?php 
require_once 'connection.php';


$query = "SELECT * FROM products";
$result = $conn->query($query);

session_start();

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
    <style>
        .right-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        }
        #nofiltererror-message {
                padding: 0px 150px;
            }
        #searchInput {
            width: 150px;
            border: none; /* Remove the default border */
            border-bottom: 1px solid var(--darkbrown); /* Add a bottom border */
            background-color: var(--lightbrown);
        }
        .search-bar {
        display: flex;
        align-items: center;
        }

        #searchForm {
            display: flex;
            align-items: center;
            border: none; /* Remove the form border */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            background: none; /* Remove default background */
        }
        #searchInput {
            border: none;
            border-bottom: solid 1px var(--darkbrown);
            width: 150px;
            outline: none;
            width: 150px; /* Set the width as needed */
            margin-right: 10px; /* Add margin as needed */
        }

        #searchButton {
          cursor: pointer;
            border: none;
            background: none;
            padding: 0;
        }

        #searchButton img {
            width: 25px; /* Set the image size as needed */
        }
  </style>

    <script>
        // JavaScript function to redirect to a new page
        // function productDescription(productId) {
        //     window.location.href = 'product_description.php?id=' + productId;
        // }
        function productDescription(productId) {
            alert('Product ID: ' + productId);
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
            var noMatchingProducts = true; // Flag to track if no products match the filter criteria

            for (var i = 0; i < productCards.length; i++) {
                var category = productCards[i].getAttribute('data-category');
                var price = parseFloat(productCards[i].getAttribute('data-price'));

                var isCategoryMatch = selectedCategoryValues.length === 0 || selectedCategoryValues.includes(category);
                var isPriceMatch = price >= minPrice && price <= maxPrice;

                if (isCategoryMatch && isPriceMatch) {
                    productCards[i].style.display = 'block';
                    noMatchingProducts = false; // Products match the filter, so set the flag to false
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

            // Construct the new URL based on filters
            var baseUrl = window.location.href.split('?')[0]; // Get the base URL
            var params = new URLSearchParams();

            if (selectedCategoryValues.length > 0) {
                params.set('categories', selectedCategoryValues.join(','));
            }
            if (minPrice > 0) {
                params.set('minPrice', minPrice);
            }
            if (maxPrice < Number.MAX_VALUE) {
                params.set('maxPrice', maxPrice);
            }

            var newUrl = baseUrl + '?' + params.toString();

            // Update the browser URL without refreshing the page
            history.pushState(null, '', newUrl);

            closeFilterModal();
        }

        // Function to apply filters based on URL parameters
        function applyFiltersFromURL() {
            var urlParams = new URLSearchParams(window.location.search);
            var selectedCategories = urlParams.getAll('categories');
            var minPrice = parseFloat(urlParams.get('minPrice')) || 0;
            var maxPrice = parseFloat(urlParams.get('maxPrice')) || Number.MAX_VALUE;

            var productCards = document.querySelectorAll('.product-card');
            var noMatchingProducts = true;

            for (var i = 0; i < productCards.length; i++) {
                var category = productCards[i].getAttribute('data-category');
                var price = parseFloat(productCards[i].getAttribute('data-price'));

                var isCategoryMatch = selectedCategories.length === 0 || selectedCategories.includes(category);
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
        }

        // Call the function on page load to apply filters from URL parameters
        window.onload = applyFiltersFromURL;




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
        <div class="nav-logo-container">
            <img class="nav-logo" src="../images/Volvet.png">
        </div>
        
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

    <div class="product">
        <div class="product-top">
            <h1>SHOP ALL</h1>
            <div class="product-top-right">
            <span>
                    <input type="button" value="Filter" onclick="openFilterModal()">
            </span>
            </div>
        </div>

        
        <div id="filterModal" class="filtermodal" style="display: none;">
            <div class="modal-content">

            <div class="filter-content">
                <div class="category-filter">   
                    <label>Categories</label><br>               
                    <label>
                        <input type="checkbox" name="category" value="Clothes"> Clothes
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
                    <input type="button" class="cancelfilterButton" value="Cancel" onclick="closeFilterModal()">
            </div>
            </div>
        </div>

        <div id="nofiltererror-message" style="display: none;">
        <p>There are no products here.</p>
        </div>
        
        <div class="product-container">
        <?php
        require_once 'connection.php';

        $query = "SELECT * FROM products";
        $result = $conn->query($query);

        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['id'];
            $productCategory = $row['category']; 
            $productPrice = $row['product_price'];

            echo '<div class="product-card" data-category="' . $productCategory . '" data-price="' . $productPrice . '">';
            echo '<img src="../images/' . $row["product_image"] . '" alt="' . $row["product_image"] . '" onclick="productDescription(' . $productId . ')">';
            echo '<h5>' . $row["product_name"] . '</h5>';
            echo '<h6>$' . $row["product_price"] . '</h6>';
            echo '</div>';
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
                <span class="subscribe-email" ><input type="text" name="subscribe-email" id="subscribe-email" placeholder="Enter your email..."></span>
                <span class="subscribe-submit"><input type="submit" value="submit"></span>
            </form>
        </div>
        <div id="subscription-message-container" style="display: none;">
            <p id="subscription-message">Subscription message will appear here.</p>
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