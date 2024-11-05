<?php
// Step 1: Connect to the database using procedural style
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "ecommerce"; // Your database name
// $port= 3307;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname,);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>