<?php
session_start();

// Include your database connection script
include 'connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dentistId = $_POST['dentist_id']; // Ensure this variable is being set correctly
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Validate the inputs here

    // Insert the booking into the database
    $stmt = $conn->prepare("INSERT INTO Appointments (DentistID, AppointmentDate, AppointmentTime, Status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iss", $dentistId, $date, $time);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Appointment booked successfully!";
        // Redirect to a confirmation page or back to the dashboard
        header("Location: bookconfirm.php");
    } else {
        echo "Error booking appointment.";
    }

    $stmt->close();
    $conn->close();
}
?>