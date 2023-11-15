<?php
session_start();
include 'connection.php';

// Validate and sanitize PatientID
$patientID = isset($_SESSION['PatientID']) ? (int)$_SESSION['PatientID'] : 0;

// Validate and sanitize AppointmentID (should be passed via GET request or stored in session)
$appointmentID = isset($_GET['appointment_id']) ? (int)$_GET['appointment_id'] : 0;

if ($patientID <= 0 || $appointmentID <= 0) {
    // Handle invalid PatientID or AppointmentID
    // Redirect to an error page or display an error message
    exit('Invalid Patient or Appointment ID.');
}

// Cancel the appointment
$stmt = $conn->prepare("DELETE FROM Appointments WHERE AppointmentID = ? AND PatientID = ?");
$stmt->bind_param("ii", $appointmentID, $patientID);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Success, appointment cancelled
    $_SESSION['booking_status_message'] = "Your appointment has been cancelled successfully!";
} else {
    // Error, appointment not cancelled
    $_SESSION['booking_status_message'] = "There was an error cancelling your appointment.";
}

$stmt->close();
$conn->close();

// Redirect to the booking cancellation confirmation page
header("Location: booking_cancellation_confirmation.php");
exit;
?>