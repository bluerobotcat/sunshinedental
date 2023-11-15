<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Booking Cancellation | Sunshine Dental Clinic</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
      #booking-confirmation h1 {
        font-size: 2.5em;
        margin-bottom: 20px;
      }

      #booking-confirmation p {
        font-size: 1.2em;
        margin-bottom: 40px;
      }

      .button {
        /* Your button styling */
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
      <section id="booking-confirmation">
        <h1>Appointment Status</h1>
        <p>
          <?php
          // Display the status message from the session
          echo $_SESSION['booking_status_message'];
          // Clear the status message from the session
          unset($_SESSION['booking_status_message']);
          ?>
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