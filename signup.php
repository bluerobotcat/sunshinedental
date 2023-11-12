<?php
session_start(); // Start a new session or resume the existing one
include 'connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection script
   
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $contactNo = $_POST['contact-no'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = md5($password);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO patients (FirstName, LastName, ContactInfo, Email, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $contactNo, $email, $password);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to the login page or wherever you want
        header("Location: login.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>