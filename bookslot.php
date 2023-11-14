<?php
// Start the PHP session
session_start();

// Include your database connection file
include 'connection.php';

// Initialize variables
$availableTimeSlots = [];
$dentistInfo = null;
$dentistId = null;

// Check if the dentist_id is set in the URL and sanitize it
if (isset($_GET['dentist_id'])) {
    $dentistId = filter_var($_GET['dentist_id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch the dentist's details
    $stmt = $conn->prepare("SELECT FirstName, LastName, Specialization, Experience, imgsrc FROM Dentists WHERE DentistID = ?");
    $stmt->bind_param("i", $dentistId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $dentistInfo = $result->fetch_assoc();
    }

    // Fetch the dentist's available time slots from the database
    $stmt = $conn->prepare("SELECT SlotID, SlotDateTime FROM TimeSlots WHERE DentistID = ? AND IsBooked = 0 AND SlotDateTime > NOW() ORDER BY SlotDateTime");
    $stmt->bind_param("i", $dentistId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $availableTimeSlots[] = $row;
    }

    $stmt->close();
}

// Fetch the services offered by the dentist
$offeredServices = [];
$serviceStmt = $conn->prepare("
    SELECT services.ServiceID, services.ServiceName 
    FROM services 
    JOIN dentistservices ON services.ServiceID = dentistservices.ServiceID 
    WHERE dentistservices.DentistID = ?
");
$serviceStmt->bind_param("i", $dentistId);
$serviceStmt->execute();
$serviceResult = $serviceStmt->get_result();

while ($serviceRow = $serviceResult->fetch_assoc()) {
    $offeredServices[] = $serviceRow;
}


// Fetching service descriptions
$servicesQuery = "SELECT ServiceID, ServiceName, Description FROM Services";
$servicesResult = $conn->query($servicesQuery);
$servicesDescriptions = [];
while ($service = $servicesResult->fetch_assoc()) {
    $servicesDescriptions[$service['ServiceID']] = $service;
}

$serviceStmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Selection | Sunshine Dental Clinic</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
      .dentist-card {
        background-color: #ffffff;
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .dentist-card img {
        max-width: 100%;
        border-radius: 5px;
      }

      .dentist-card h2 {
        font-size: 1.5em;
        margin-bottom: 20px;
      }

      .dentist-card p {
        font-size: 1em;
        margin-bottom: 20px;
      }

      h2 {
        font-size: 1.8em;
        margin-bottom: 20px;
      }

      h2,
      h3 {
        font-weight: bold;
      }

      form {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      label {
        font-weight: bold;
      }

      .form-group {
        margin-bottom: 20px;
      }

      select,
      input[type="date"],
      input[type="time"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
      }

      #booking-details p {
        text-align: left; /* Align left */
        margin: 0 auto; /* Center horizontally */
        max-width: 600px; /* Set a max width to limit the content width */
      }

      
      #dentist-info img {
    max-width: 100%; /* ensures the image is never wider than its container */
    height: auto; /* maintains the aspect ratio of the image */
    border-radius: 10px; /* rounds the corners of the image */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* adds a subtle shadow for depth */
    margin-bottom: 20px; /* adds some space below the image */
}

/* Button Styles */
.button {
  display: inline-block;
  font-size: 18px;
  color: #fff;
  background: #5bc0eb;
  padding: 10px 20px;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.button:hover {
  background: #9bc53d;
}


/* If you want to set a specific width for larger screens and center the image */
@media (min-width: 768px) {
    #dentist-info img {
        max-width: 300px; /* a fixed max-width for larger screens */
        display: block; /* allows margin auto to center the image */
        margin: 0 auto 20px; /* centers the image and adds space below */
    }
}

#dentist-info {
    text-align: center; /* centers the text and any inline elements like images */
    background-color: #f8f8f8; /* a light background color that matches the theme */
    padding: 30px; /* adds padding around the content */
    border-radius: 10px; /* rounds the corners of the container */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* adds a shadow for depth */
    margin-bottom: 30px; /* adds space below the dentist-info section */
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
    <?php if (isset($dentistInfo)): ?>
        <div id="dentist-info">
          <img src="<?php echo htmlspecialchars($dentistInfo['imgsrc']); ?>" alt="Dentist Image" />
          <h2><?php echo htmlspecialchars($dentistInfo['FirstName']) . ' ' . htmlspecialchars($dentistInfo['LastName']); ?></h2>
          <p>Specialization: <?php echo htmlspecialchars($dentistInfo['Specialization']); ?></p>
          <p><?php echo htmlspecialchars($dentistInfo['Experience']); ?></p>
        </div>
    <?php endif; ?>

    <section id="appointment-date">
        <?php if (!empty($availableTimeSlots)): ?>
            <form action="submitbooking.php" method="POST">
                <input type="hidden" name="dentist_id" value="<?php echo htmlspecialchars($dentistId); ?>">
                <label for="service">Choose a service:</label>
                <select name="service" id="service" required>
                    <?php foreach ($offeredServices as $service): ?>
                        <option value="<?php echo $service['ServiceID']; ?>">
                            <?php echo htmlspecialchars($service['ServiceName']); ?>
                        </option>
                    <?php endforeach; ?>
                    
                </select>
                <div><br /><div>
                <label for="timeslot">Choose a time slot:</label>
                <select name="timeslot" id="timeslot" required>
                    <?php foreach ($availableTimeSlots as $slot): ?>
                        <option value="<?php echo $slot['SlotID']; ?>">
                            <?php echo date('F j, Y, g:i a', strtotime($slot['SlotDateTime'])); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div><br /><div>
                <button type="submit" class="button">Book Now</button>
            </form>
        <?php else: ?>
            <p>No available time slots.</p>
        <?php endif; ?>
    </section>
</main>

    <footer>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="dentists.html">Dentists</a></li>
          <li><a href="aboutus.html">About Us</a></li>
          <li><a href="contactus.html">Contact Us</a></li>
          <li><a href="login.html">Dentist Login</a></li>
        </ul>
      </nav>
      <p>&copy; 2023 Sunshine Dental Clinic. All rights reserved.</p>
    </footer>
  </body>
</html>
