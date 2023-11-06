<?php 
    require_once ('connection.php');

    session_start();

    if(isset($_SESSION['sessionId'])) {
        $sessionId = $_SESSION['sessionId'];

        $sessionQuery = "SELECT * FROM cart WHERE session_id = $sessionId";
        $sessionResult = $conn-> query($sessionQuery);
        
        while ($sessionRow = mysqli_fetch_assoc($sessionResult)) {
            echo $sessionRow['product_price'];

        }

    } 

    
?>