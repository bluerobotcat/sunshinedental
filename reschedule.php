<?php
session_start();
include 'connection.php';

// Initialize error message
$error = '';



$patientID = $_SESSION['PatientID'];
$appointmentID = isset($_GET['appointment_id']) ? intval($_GET['appointment_id']) : 0;
echo "Debug: Appointment ID is set to: " . $appointmentID;


// Check if the patient is logged in
if (!isset($_SESSION['PatientID'])) {
    $error = 'Patient not logged in.';
}

// Check if the Appointment ID is provided
if (!isset($_GET['AppointmentID'])) {
    $error .= ' Appointment ID not provided.';
}

// If there are any errors, stop further execution and display the error
if ($error) {
    echo $error;
    exit;
}
// Fetch the current appointment's details
$stmt = $conn->prepare("SELECT * FROM appointments WHERE AppointmentID = ? AND PatientID = ?");
$stmt->bind_param("ii", $appointmentID, $patientID);
$stmt->execute();
$currentAppointment = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Check if the Appointment ID is provided
if (!$appointmentID) {
    $error .= ' Appointment ID not provided.';
}


// Add debug statements
echo "PatientID: " . $_SESSION['PatientID'] . "<br>";
echo "Appointment ID: " . $_GET['AppointmentID'] . "<br>";

// Fetch available time slots for the same dentist
$stmt = $conn->prepare("SELECT * FROM timeslots WHERE DentistID = ? AND IsBooked = 0 AND SlotDateTime > NOW()");
$stmt->bind_param("i", $currentAppointment['DentistID']);
$stmt->execute();
$availableSlots = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Add a debug statement
echo "Available Slots: ";
print_r($availableSlots);


// Handle form submission for rescheduling
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_slot'])) {
    $newSlotID = $_POST['new_slot'];

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Free up the old time slot
        $freeOldSlotStmt = $conn->prepare("UPDATE timeslots SET IsBooked = 0 WHERE SlotID = ?");
        $freeOldSlotStmt->bind_param("i", $currentAppointment['SlotID']);
        $freeOldSlotStmt->execute();
        $freeOldSlotStmt->close();

        // Book the new time slot
        $bookNewSlotStmt = $conn->prepare("UPDATE timeslots SET IsBooked = 1 WHERE SlotID = ?");
        $bookNewSlotStmt->bind_param("i", $newSlotID);
        $bookNewSlotStmt->execute();
        $bookNewSlotStmt->close();

        // Update the appointment with the new time slot
        $updateAppointmentStmt = $conn->prepare("UPDATE appointments SET SlotID = ? WHERE AppointmentID = ?");
        $updateAppointmentStmt->bind_param("ii", $newSlotID, $appointmentID);
        $updateAppointmentStmt->execute();
        $updateAppointmentStmt->close();

        // Commit transaction
        $conn->commit();

        // Redirect to confirmation page
        $_SESSION['reschedule_success'] = "Your appointment has been successfully rescheduled.";
        header('Location: appointment_confirmation.php');
        exit;
    } catch (Exception $e) {
        // An error occurred, roll back the transaction
        $conn->rollback();
        $_SESSION['reschedule_error'] = $e->getMessage();
    } finally {
        // Always close the connection
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reschedule Appointment | Sunshine Dental Clinic</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        /* Additional Styling for Reschedule Section */
        #reschedule h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        #reschedule p {
            font-size: 1.2em;
            margin-bottom: 40px;
        }

        #reschedule form {
            margin-top: 20px;
        }

        #reschedule label {
            display: block;
            margin-bottom: 10px;
        }

        #reschedule select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #reschedule button {
            background-color: #5bc0eb;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        #reschedule button:hover {
            background-color: #4ca8d8;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">Sunshine Dental Clinic</div>
        </div>
    </header>

    <main class="container">
        <section id="reschedule">
            <h1>Reschedule Appointment</h1>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="post" action="reschedule_appointment.php">
                <label for="new_slot">Choose a new time slot:</label>
                <select name="new_slot" id="new_slot">
                    <?php foreach ($availableSlots as $slot): ?>
                        <option value="<?php echo $slot['SlotID']; ?>">
                            <?php echo (new DateTime($slot['SlotDateTime']))->format('d M Y, H:i'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Reschedule</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="aboutus.html">About Us</a></li>
                    <li><a href="contactus.html">Contact Us</a></li>
                    <li><a href="login.html">Dentist Login</a></li>
                </ul>
            </nav>
            <p>&copy; 2023 Sunshine Dental Clinic. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
