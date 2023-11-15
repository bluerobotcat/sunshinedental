<?php
session_start();

// Check if the success message is set in the session, otherwise redirect to the dashboard or home page
if (!isset($_SESSION['reschedule_success_message'])) {
    // Redirect to the dashboard or home page
    // header("Location: dashboard.php");
    // exit;
}

// Retrieve the success message if set, otherwise set a default message
$rescheduleSuccessMessage = isset($_SESSION['reschedule_success_message']) ? $_SESSION['reschedule_success_message'] : 'Appointment rescheduled successfully.';

// Clear the success message from the session
unset($_SESSION['reschedule_success_message']);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reschedule Confirmation | Sunshine Dental Clinic</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
      #reschedule-confirmation h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
      }

      #reschedule-confirmation p {
        font-size: 1.2em;
        margin-bottom: 40px;
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
      <section id="reschedule-confirmation">
        <h1>Appointment Rescheduled</h1>
        <p>
          <?php echo htmlspecialchars($rescheduleSuccessMessage); ?>
        </p>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
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