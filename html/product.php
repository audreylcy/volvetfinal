<?php 
require_once 'connection.php';


$query = "SELECT * FROM products";
$result = $conn->query($query);

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

            for (var i = 0; i < productCards.length; i++) {
            var category = productCards[i].getAttribute('data-category');
            var price = parseFloat(productCards[i].getAttribute('data-price'));

            var isCategoryMatch = selectedCategoryValues.length === 0 || selectedCategoryValues.includes(category);
            var isPriceMatch = price >= minPrice && price <= maxPrice;

            if (isCategoryMatch && isPriceMatch) {
                productCards[i].style.display = 'block';
            } else {
                productCards[i].style.display = 'none';
            }
        }

            closeFilterModal();
        }

        //search scripts
        function toggleSearchInput() {
        var searchForm = document.getElementById('searchForm');
        searchForm.style.display = searchForm.style.display === 'block' ? 'none' : 'block';
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
        <div class="nav-logo-container">
            <img class="nav-logo" src="../images/Volvet.png">
        </div>
        
        <div class="right-nav">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search...">
                <img src="../images/icon_search.png" id="searchIcon">
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