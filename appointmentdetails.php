<?php
session_start();
include 'connection.php';

// Ensure the patient is logged in and the appointment ID is provided
if (!isset($_SESSION['PatientID'])) {
    // Redirect to an error page or display an error message
    exit('Patient not logged in');
}

$patientID = $_SESSION['PatientID'];
$appointmentID = $_GET['AppointmentID'];

// Fetch the current appointment's details
$stmt = $conn->prepare("SELECT * FROM appointments WHERE AppointmentID = ? AND PatientID = ?");
$stmt->bind_param("ii", $appointmentID, $patientID);
$stmt->execute();
$currentAppointment = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch available time slots for the same dentist
$stmt = $conn->prepare("SELECT * FROM timeslots WHERE DentistID = ? AND IsBooked = 0 AND SlotDateTime > NOW()");
$stmt->bind_param("i", $currentAppointment['DentistID']);
$stmt->execute();
$availableSlots = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Check if the form was submitted to reschedule the appointment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reschedule'])) {
    // The hidden field should send the appointment ID
    $appointmentID = $_POST['appointment_id'];
    // Redirect to reschedule.php with the appointment ID
    header("Location: reschedule.php?appointment_id=" . urlencode($appointmentID));
    exit;
}


// If the cancel button is pressed
if (isset($_POST['cancel'])) {
    $stmt = $conn->prepare("UPDATE TimeSlots SET IsBooked = 0 WHERE SlotID = ?");
    $stmt->bind_param("i", $appointmentDetails['SlotID']);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM Appointments WHERE AppointmentID = ?");
    $stmt->bind_param("i", $appointmentDetails['AppointmentID']);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Appointment cancelled successfully.";
    } else {
        $_SESSION['error'] = "Failed to cancel the appointment.";
    }
    $stmt->close();
    header('Location: appointment_status.php'); // Redirect to a page to show the status (success or error) after cancellation attempt
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Appointment Details | Sunshine Dental Clinic</title>
    <style>
      .appointment-details {
        font-size: 1em;
        margin-bottom: 20px;
      }
      .appointment-details p {
        margin-bottom: 10px;

      }
      .button {
        padding: 10px;
        margin: 5px;
        cursor: pointer;
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
    <?php if (count($appointmentDetails) > 0): ?>
    <ul>
        <?php foreach ($appointmentDetails as $appointment): ?>
            <div class="appointment-details">
                <h2>Appointment Details</h2>
                <p>Dentist: <?php echo htmlspecialchars($appointmentDetails['DentistFirstName'] . ' ' . $appointmentDetails['DentistLastName']); ?></p>
                <p>Specialisation: <?php echo htmlspecialchars($appointmentDetails['Specialization']); ?></p>
                <p>Appointment ID: <?php echo htmlspecialchars($appointment["AppointmentID"]); ?></p>
                <p>Date: <?php echo (new DateTime($appointmentDetails['SlotDateTime']))->format('d M Y, l'); ?></p>
            <p>Time: <?php echo (new DateTime($appointmentDetails['SlotDateTime']))->format('h:i a'); ?></p>
            <p>Treatment: <?php echo htmlspecialchars($appointmentDetails['ServiceName']); ?></p>
            <p>Description: <?php echo htmlspecialchars($appointmentDetails['Description']); ?></p>
                <p>Status: <?php echo htmlspecialchars($appointment["Status"]); ?></p>
                <!-- Add more appointment details you want to display -->
                
                <!-- Reschedule/Cancel buttons with PatientID -->
                <a href="reschedule.php?appointmentID=<?php echo $appointment['AppointmentID']; ?>&patientID=<?php echo $patientID; ?>">
                    <button class="button">RESCHEDULE</button>
                </a>
                
                <a href="cancel.php?appointmentID=<?php echo $appointment['AppointmentID']; ?>&patientID=<?php echo $patientID; ?>">
                    <button class="button">CANCEL</button>
                </a>
        </div>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You have no appointments scheduled.</p>
<?php endif; ?>
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