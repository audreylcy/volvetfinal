<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$sessionId = session_id();


require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];


    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();


            if (password_verify($password, $user["password"])) {

                $_SESSION['user_email'] = $user['email'];


                header('Location: profile.php'); 
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

    header('Location: login.html?error=invalidrequest');
    exit();
}
