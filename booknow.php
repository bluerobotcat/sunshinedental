<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Dentists | Sunshine Dental Clinic</title>
  <link rel="stylesheet" href="styles.css">
  <style>  /* Add this CSS to make the display smaller and fit three dentists in a row */
    .section-background .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(20rem, 1fr)); /* Adjusted minmax size */
      gap: 1rem;
      justify-content: center; /* Center align the boxes */
    }

    .section-background .box-container .box {
      text-align: center;
      border: var(--border);
      max-width: 20rem; /* Added max-width to limit the width of each box */
      background-color: #f9f9f9; /* Added background color */
      transition: background-color 0.3s, color 0.3s; /* Smooth hover effect */
      cursor: pointer;
      padding: 1rem;
      margin: 1rem;
      border-radius: 10%;
    }

    .section-background .box-container .box img {
      height: 15rem; /* Adjusted image height to make them smaller */
      border-radius: 10%;
    }

    .section-background .box-container .box h2 {
      color: #333; /* Darken the title color */
      font-size: 1.5rem; /* Slightly smaller font size */
      padding: 1rem 0;
    }

    .section-background .box-container .box p {
      color: #666; /* Adjusted paragraph color */
      font-size: 1rem; /* Smaller font size */
    }

    .section-background .box-container .box:hover {
      background-color: #fff; /* Change background on hover */
    }
    
  </style>
</head>
<body>
  <header>
    <div class="container">
      <div class="logo">Sunshine Dental Clinic</div>
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="dentists.html">Dentists</a></li>
          <li><a href="aboutus.html">About Us</a></li>
          <li><a href="contactus.html">Contact Us</a></li>
          <li><a href="login.html">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    <section id="available-dentists" class="section-background">
        <h2>Available Dentists</h2>

        <div class="box-container">
            <?php
            include 'connection.php'; // Make sure this points to your actual database connection script

            $query = "SELECT DentistID, FirstName, LastName, Specialization, imgsrc FROM Dentists";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($dentist = $result->fetch_assoc()) {
                    echo '<div class="box">';
                    // Check if the 'imgsrc' key is set before trying to access it
                    if (isset($dentist['imgsrc'])) {
                        echo '<img src="' . htmlspecialchars($dentist['imgsrc']) . '" alt="Dentist Image">';
                    } else {
                        // If 'imgsrc' is not set, display a placeholder or handle it as appropriate
                        echo '<img src="default_image.jpg" alt="Default Dentist Image">';
                    }
                    echo '<h2>' . htmlspecialchars($dentist['FirstName']) . ' ' . htmlspecialchars($dentist['LastName']) . '</h2>';
                    echo '<p>' . htmlspecialchars($dentist['Specialization']) . '</p>';
                    echo '<a href="bookslot.php?dentist_id=' . $dentist['DentistID'] . '"><button class="button">Book Now</button></a>';
                    echo '</div>';
                }
            } else {
                echo "0 results";
            }

            $conn->close();
            ?>
        </div>
    </section>
</main>

  
  <!-- Footer Section -->
  <footer>
    <div class="container">
      <nav>
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="dentists.html">Dentists</a></li>
          <li><a href="aboutus.html">About Us</a></li>
          <li><a href="contactus.html">Contact Us</a></li>
          <li><a href="login.html">Login</a></li>
        </ul>
      </nav>
      <p>&copy; 2023 Sunshine Dental Clinic. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
