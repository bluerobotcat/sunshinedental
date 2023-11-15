<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Debugging session start
echo "Before session_start<br>";

session_start();

// Debugging session start
echo "After session_start<br>";

include 'connection.php'; // Adjust to the path of your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dentist_id'], $_POST['service'], $_POST['timeslot'])) {
    $dentistId = intval($_POST['dentist_id']);
    $serviceId = intval($_POST['service']);
    $timeslotId = intval($_POST['timeslot']);
    $patientId = $_SESSION['PatientID']; // Ensure that 'PatientID' is set in the session

    // Debugging session variables
    echo "PatientID: " . $_SESSION['PatientID'] . "<br>";

    if (!isset($_SESSION['PatientID']) || empty($_SESSION['PatientID'])) {
        echo "PatientID is not set or empty<br>";
    } else {
        echo "PatientID is set and not empty<br>";
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Mark the timeslot as booked
        $stmt = $conn->prepare("UPDATE timeslots SET IsBooked = 1 WHERE SlotID = ? AND DentistID = ? AND IsBooked = 0");
        $stmt->bind_param("ii", $timeslotId, $dentistId);
        $stmt->execute();
        if ($stmt->affected_rows == 0) {
            throw new Exception("Time slot is already booked or does not exist.");
        }
        $stmt->close();

        // Insert the booking into the Appointments table
        $stmt = $conn->prepare("INSERT INTO appointments (PatientID, ServiceID, Status, SlotID) VALUES (?, ?, 'scheduled', ?)");
        $stmt->bind_param("iii", $patientId, $serviceId, $timeslotId);
        $stmt->execute();
        if ($stmt->affected_rows == 0) {
            throw new Exception("Failed to create an appointment.");
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Debugging success message
        echo "Booking success. Redirecting...<br>";

        $_SESSION['booking_success'] = "Appointment booked successfully!";
        header("Location: bookingsuccess.php");
        exit;
    } catch (Exception $e) {
        // Log the entire exception to a file
        error_log('Exception: ' . $e->getMessage() . "\n" . $e->getTraceAsString(), 3, 'error.log');

        // Debugging error message
        echo "Error: " . $e->getMessage() . "<br>";

        $conn->rollback();
        $_SESSION['booking_error'] = "An unexpected error occurred. Please try again later.";
        // Debugging error message
        echo "Redirecting to bookingerror.php...<br>";
        header("Location: bookingerror.php");
        exit;
    } finally {
        // Debugging connection close
        echo "Closing connection...<br>";
        $conn->close();
    }
} else {
    $_SESSION['booking_error'] = "Invalid request.";
    // Debugging error message
    echo "Invalid request. Redirecting to bookingerror.php...<br>";
    header("Location: bookingerror.php");
    exit;
}
?>
