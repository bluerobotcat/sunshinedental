<?php
session_start(); // Start the session


// Include the database connection file
require_once 'connection.php';

// Include the appointments functions
require_once 'appointments.php';

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Fetch user information from the session
$patientID = $_SESSION['PatientID'];
$firstName = $_SESSION["FirstName"];
$lastName = $_SESSION["LastName"];
$contactInfo = $_SESSION['ContactInfo'];
$email = $_SESSION['Email'];
$password = $_SESSION['Password']; 

// Fetch appointments if logged in
$query = "SELECT Appointments.*, TimeSlots.SlotDateTime 
          FROM Appointments
          JOIN TimeSlots ON Appointments.SlotID = TimeSlots.SlotID
          WHERE Appointments.PatientID = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['PatientID']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$patientAppointments = array();

while ($appointment = $result->fetch_assoc()) {
    $slotDateTime = new DateTime($appointment['SlotDateTime']);
    $appointment['AppointmentDate'] = $slotDateTime->format('Y-m-d');
    $appointment['AppointmentTime'] = $slotDateTime->format('H:i:s');
    $patientAppointments[] = $appointment;
}


// When the user clicks 'Sign Out', destroy the session and redirect to the homepage or login page
if (isset($_GET['action']) && $_GET['action'] == 'signout') {
    session_destroy();
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Dashboard | Sunshine Dental Clinic</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
      /* Reset some default styles */
      body, h1, h2, p, ul, li {
        margin: 5;
        padding: 5;
      }

      /* Layout */
.container {
  max-width: 1200px;
  margin: auto;
  padding: 0 20px;
}


      #welcome, 
      #your-appointment,
      #booking,
      #appointment,
      #logout {
        text-align: center;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
      }

      #booking {
        background-color: rgba(173, 216, 230, 0.5); /* Cooler and lighter pastel blue */
      }

      
      #welcome{
        background-color: rgba(240, 223, 200, 0.7); /* Cooler and lighter pastel orange */
      }

      #your-appointment {
        background-color: rgba(200, 237, 200, 0.7); /* Cooler and lighter pastel green */
      }

      #logout{
        background-color: rgba(244, 198, 198, 0.7); /* Cooler and lighter pastel peach */
      }

      #appointment{
        background-color: rgba(180, 205, 205, 0.7); /* Cooler and lighter pastel mint */
      }

      .button {
        width: 200px; /* Fixed width for all buttons */
      }

      /* Adding some spacing and styling to the sections */
      section {
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 8px;
      }

      
    </style>
  </head>

  <header>
      <div class="container">
        <div class="logo">Sunshine Dental Clinic</div>
      </div>
    </header>
    <body>

    <main class="container">
    <section id="welcome">
    <h1>Welcome, <?php echo htmlspecialchars($firstName); ?></h1>
    <p>
        Your smile is our priority. Experience comprehensive dental care with our professional team.
    </p>
    </section>
      <section id="your-appointment">
    <h2>Your Appointments</h2>
    <?php if (count($patientAppointments) > 0): ?>
    <ul>
        <?php foreach ($patientAppointments as $appointment): ?>
            <div>
                <p>Appointment ID: <?php echo htmlspecialchars($appointment["AppointmentID"]); ?></p>
                <p>Date: <?php echo htmlspecialchars($appointment["AppointmentDate"]); ?></p>
                <p>Time: <?php echo htmlspecialchars($appointment["AppointmentTime"]); ?></p>
                <p>Status: <?php echo htmlspecialchars($appointment["Status"]); ?></p>
                <!-- Add more appointment details you want to display -->
                
                <!-- Reschedule/Cancel buttons with PatientID -->
                <a href="reschedule.php?appointmentID=<?php echo $appointment['AppointmentID']; ?>&patientID=<?php echo $patientID; ?>">
                    <button class="button">RESCHEDULE</button>
                </a>
                
                <a href="cancel.php?appointmentID=<?php echo $appointment['AppointmentID']; ?>&patientID=<?php echo $patientID; ?>">
                    <button class="button">CANCEL</button>
                </a>
                <div><br /></div>
            </div>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>You have no appointments scheduled.</p>
<?php endif; ?>
    </section>

      <section id="booking">
        <h2>Interested in having clean teeth?</h2>
        <a href="booknow.php">
          <button class="button">BOOK NOW</button>
        </a>
      </section>

      <section id="appointment">
        <h2>Want to change your appointment?</h2>
        <a href="appointmentdetails.php">
          <button class="button">RESCHEDULE / CANCEL</button>
        </a>
      </section>

    <section id="logout">
      <form action="logout.php" method="post">
          <button type="submit" class="button">LOG OUT</button>
      </form>
    </section>
    </body>
  </main>
    
    <footer>
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
    </footer>

</html>
