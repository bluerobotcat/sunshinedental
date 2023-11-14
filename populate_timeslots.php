<?php

$servername = "localhost";  // The server's hostname (usually "localhost" for XAMPP)
$username = "root";         // Your MySQL username (usually "root" for XAMPP)
$password = "";             // Your MySQL password (usually empty for XAMPP)
$database = "sunshine_dental";      // The name of your database
$port = "3308";            // Add a semicolon here

$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the start and end dates
$startDate = new DateTime('2023-11-14');
$endDate = new DateTime('2023-12-14');

// Set the office hours
$officeHoursStart = 9; // 9:00 AM
$officeHoursEnd = 17; // 5:00 PM

// Generate SQL statements
$sqlStatements = "";

for ($dentistID = 1; $dentistID <= 15; $dentistID++) {
    for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
        for ($hour = $officeHoursStart; $hour < $officeHoursEnd; $hour++) {
            $slotDateTime = $date->format('Y-m-d') . " " . sprintf('%02d', $hour) . ":00:00";
            $sqlStatements .= "INSERT IGNORE INTO `timeslots` (`DentistID`, `SlotDateTime`, `IsBooked`) VALUES ($dentistID, '$slotDateTime', 0);\n";
        }
    }
}

// Save the SQL statements to a file
file_put_contents('populate_timeslots.sql', $sqlStatements);

// Close the database connection
$conn->close();

echo "Script generated successfully. Check 'populate_timeslots.sql' file.";

?>
