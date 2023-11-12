<?php
$servername = "localhost";  // The server's hostname (usually "localhost" for XAMPP)
$username = "root";         // Your MySQL username (usually "root" for XAMPP)
$password = "";             // Your MySQL password (usually empty for XAMPP)
$database = "sunshine_dental";      // The name of your database
$port = "3308";            // Add a semicolon here

// Create a connection to the MySQL server
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute the SQL query to create the table
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // You should use "." for string concatenation
} else {
    echo "";
}


?>
