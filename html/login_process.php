<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session at the beginning of your script
session_start();

$sessionId = session_id();

// Include your database connection code here
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the form was submitted using the POST method

    // Retrieve the email and password values from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Prepare and execute a SELECT query to check the user's credentials
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify the password using password_verify
            if (password_verify($password, $user["password"])) {
                // Password matches; login successful

                // Store user data in the session
                $_SESSION['user_email'] = $user['email'];

                // Redirect to the user's account page
                header('Location: profile.php'); // Update to the correct profile page
                exit();
            } else {
                // Password is incorrect
                echo '<script>alert("Password Incorrect. Please log in again!"); window.location.href = "login.php";</script>';
                exit();
            }
        } else {
            // User not found
            echo '<script>alert("User not found. Please sign up."); window.location.href = "signup.php";</script>';
            exit();
        }
             
    } else {
        // Handle database query error
        header('Location: login.html?error=dbqueryfailed');
        exit();
    }
} else {
    // Handle the case where the form was not submitted using POST
    // You can show an error message or redirect the user back to the login form.
    header('Location: login.html?error=invalidrequest');
    exit();
}
