<?php
session_start();

include 'connection.php'; // Adjust to the path of your database connection file

// Function to validate the date and time slot
function validateDate($date, $timeslotId, $conn) {
    $now = new DateTime();
    $selectedDate = DateTime::createFromFormat('Y-m-d', $date);

    // Debugging statement: Print the current date and selected date
    echo "Current Date: " . $now->format('Y-m-d') . "<br>";
    echo "Selected Date: " . $selectedDate->format('Y-m-d') . "<br>";

    if ($selectedDate < $now) {
        // Debugging statement
        echo "Selected date is before the current date.<br>";
        return false;
    }

    // Validate if the slotDateTime corresponds to the selected date
    $stmt = $conn->prepare("SELECT SlotDateTime FROM timeslots WHERE SlotID = ?");
    $stmt->bind_param("i", $timeslotId);
    $stmt->execute();
    $result = $stmt->get_result();
    $slotInfo = $result->fetch_assoc();
    $stmt->close();

    if (!$slotInfo) {
        // Debugging statement
        echo "Slot information not found.<br>";
        return false;
    }

    $slotDateTime = new DateTime($slotInfo['SlotDateTime']);

    // Debugging statement: Print the slot date and time
    echo "Slot Date and Time: " . $slotDateTime->format('Y-m-d H:i:s') . "<br>";

    if ($slotDateTime->format('Y-m-d') != $date) {
        // Debugging statement
        echo "Slot date does not match the selected date.<br>";
        return false;
    }

    return true;
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['dentist_id'], $_POST['service'], $_POST['timeslot'], $_POST['date'])) {
    $dentistId = $_POST['dentist_id'];
    $serviceId = $_POST['service'];
    $timeslotId = $_POST['timeslot'];
    $selectedDate = $_POST['date'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Validate the date
        if (!validateDate($selectedDate, $timeslotId, $conn)) {
            throw new Exception("Invalid date for appointment or timeslot does not match the selected date.");
        }

        // Mark the timeslot as booked
        $updateStmt = $conn->prepare("UPDATE timeslots SET IsBooked = 1 WHERE SlotID = ?");
        $updateStmt->bind_param("i", $timeslotId);
        $updateStmt->execute();
        if ($updateStmt->affected_rows == 0) {
            throw new Exception("Error updating time slot.");
        }
        $updateStmt->close();

        // Insert the booking into the Appointments table
        $insertStmt = $conn->prepare("INSERT INTO appointments (PatientID, DentistID, ServiceID, SlotID, Status) VALUES (?, ?, ?, ?, 'scheduled')");
        $insertStmt->bind_param("iiii", $_SESSION['patient_id'], $dentistId, $serviceId, $timeslotId); // Assuming the patient ID is stored in session
        $insertStmt->execute();
        if ($insertStmt->affected_rows == 0) {
            throw new Exception("Error booking appointment.");
        }
        $insertStmt->close();

        // Commit transaction
        $conn->commit();

        // Booking successful
        $_SESSION['booking_success'] = "Appointment booked successfully!";
        header("Location: bookingsuccess.php"); // Adjust the redirect location to your success page
        exit;
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        $_SESSION['booking_error'] = $e->getMessage();
        // header("Location: error.php"); // Adjust the redirect location to your error page
        exit;
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Invalid form submission
    $_SESSION['booking_error'] = "Invalid form submission.";
    // header("Location: error.php");
    exit;
}
?>
