<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();

$sessionId = session_id();

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

    <div class="login">
        <div>
            <h1>SIGNUP</h1>
            <p>Join our family now!</p>
            <form class="form" action="signup_process.php" method="post">
                <span class="text-input">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <span id="emailError" class="error"></span>

                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span id="passwordError" class="error"></span>

                    <input type="password" id="confirm_password" name="confirm_password" placeholder=" Confirm Password" required>
                    <span id="confirmPasswordError" class="error"></span>

                    <input type="date" id="date_of_birth" name="date_of_birth" placeholder="Date of Birth" required>
                    <span id="dateOfBirthError" class="error"></span>
                </span>
                
                <span class="buttons">
                    <input class="signup-signup" type="submit" value="Sign Up"> 
                </span>
            </form>
        </div>
    </div>
    
    <!--<div class="subscribe">
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
    </div>-->
    
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

    <script>
    // Add event listeners for real-time validation
    document.getElementById("email").addEventListener("input", validateEmail);
    document.getElementById("password").addEventListener("input", validatePassword);
    document.getElementById("confirm_password").addEventListener("input", validateConfirmPassword);
    document.getElementById("date_of_birth").addEventListener("input", validateDateOfBirth);

    function validateEmail() {
        const email = document.getElementById("email").value;
        const emailError = document.getElementById("emailError");

        if (!emailIsValid(email)) {
            emailError.textContent = "Invalid Email Address";
        } else {
            emailError.textContent = "";
        }

        checkForm();
    }

    function validatePassword() {
        const password = document.getElementById("password").value;
        const passwordError = document.getElementById("passwordError");


        const alphabetRegex = /[a-zA-Z]/;
        const digitRegex = /\d/;
        const specialCharRegex = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]/;


        if (!alphabetRegex.test(password) || !digitRegex.test(password) || !specialCharRegex.test(password) || password.length < 8) {
            passwordError.textContent = "Password must have 8 characters, 1 digit & 1 special character.";
        } else {
            passwordError.textContent = "";
        }

        checkForm();
    }

    function validateConfirmPassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const confirmPasswordError = document.getElementById("confirmPasswordError");

        if (password !== confirmPassword) {
            confirmPasswordError.textContent = "Passwords do not match";
        } else {
            confirmPasswordError.textContent = "";
        }

        checkForm();
    }

    function emailIsValid(email) {
        return /\S+@\S+\.\S+/.test(email);
    }

    function validateDateOfBirth() {
        const dateOfBirthInput = document.getElementById("date_of_birth");
        const dateOfBirthError = document.getElementById("dateOfBirthError");

        const selectedDate = new Date(dateOfBirthInput.value);
        const currentDate = new Date();

        if (selectedDate >= currentDate) {
            dateOfBirthError.textContent = "Please select a date before today";
        } else {
            dateOfBirthError.textContent = "";
        }

        checkForm();
    }

    function checkForm() {
        // Check if there are any error messages
        const errorMessages = document.querySelectorAll(".error");
        const signUpButton = document.querySelector(".signup-signup");

        // Disable the button if there are error messages
        signUpButton.disabled = Array.from(errorMessages).some(element => element.textContent !== "");
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



</body>
</html>