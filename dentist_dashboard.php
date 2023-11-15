<?php
session_start(); // Start the session


// // Include the database connection file
// require_once 'connection.php';

// // Include the appointments functions
// require_once 'appt_dent.php';

// // Check if the user is logged in, if not then redirect to login page
// if (!isset($_SESSION["success"]) || $_SESSION["success"] !== true) {
//     header("location: dentist_login.php");
//     exit;
// }

// Fetch dentist information from the session
//  $stmt = $conn->prepare("SELECT DentistID, FirstName, LastName, Email, Password FROM Dentists WHERE DentistID = ?");
//  $stmt->bind_param("i", $dentistId);
//  $stmt->execute();
//  $result = $stmt->get_result();
//  if ($result->num_rows > 0) {
//   // Output data of each row
//   while ($row = $result->fetch_assoc()) {
//       // Access data using column names
//       $dentistID =  $row["DentistID"]; 
//       $firstName = $row["FirstName"];
// $lastName = $row["LastName"];
// $email = $row['Email'];
// $password = $row['Password']; 
//   }
// } else {
//   echo "0 results";
// }
//  if ($result) {
//      $dentistInfo = $result->fetch_assoc();
//      $dentistID = $dentistInfo['DentistID'];
// $firstName = $dentistInfo["FirstName"];
// $lastName = $dentistInfo["LastName"];
// $email = $dentistInfo['Email'];
// $password = $dentistInfo['Password']; 
//  }
//  $stmt->close();

// // $dentistID = $_SESSION['DentistID'];
// // $firstName = $_SESSION["FirstName"];
// // $lastName = $_SESSION["LastName"];S
// // $email = $_SESSION['Email'];
// // $password = $_SESSION['Password']; 


// // // Fetch appointments if logged in
// $docAppointments = getDentistAppointments($dentistID, $conn);

// When the user clicks 'Sign Out', destroy the session and redirect to the homepage or login page
if (isset($_GET['action']) && $_GET['action'] == 'signout') {
    session_destroy();
    header("location: dentist_logout.html");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dentist Dashboard | Sunshine Dental Clinic</title>
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
    <h1>Welcome</h1>
    <p>
        This is your dashboard to check and reschedule your appointments with patients. 
    </p>

    </section>


      
    <section id="logout">
      <form action="logout.php" method="post">
      <a href="dentist_logout.html" class="button">LOG OUT</a>
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