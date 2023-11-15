<?php
session_start();
include 'connection.php';

// Validate and sanitize PatientID
$patientID = isset($_SESSION['patientID']) ? (int)$_SESSION['patientID'] : 0;

// Validate and sanitize AppointmentID (should be passed via GET request or stored in session)
$appointmentID = isset($_GET['appointmentID']) ? (int)$_GET['appointmentID'] : 0;

if ($patientID <= 0 || $appointmentID <= 0) {
    // Handle invalid PatientID or AppointmentID
    // Redirect to an error page or display an error message
    exit('Invalid Patient or Appointment ID.');
}

// Cancel the appointment
$stmt = $conn->prepare("DELETE FROM appointments WHERE appointmentID = ? AND patientID = ?");
$stmt->bind_param("ii", $appointmentID, $patientID);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Success, appointment cancelled
    $_SESSION['booking_status_message'] = "Your appointment has been cancelled successfully!";
} else {
    // Error, appointment not cancelled
    $_SESSION['booking_status_message'] = "There was an error cancelling your appointment.";
    // Add the following line for debugging
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect to the booking cancellation confirmation page
header("Location: booking_cancellation_confirmation.php");
exit;
?>
