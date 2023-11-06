<?php 
$conn = mysqli_connect('localhost', 'root', '', 'volvet');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>