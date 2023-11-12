<?php
// Assume $dentistId is retrieved from the URL parameter as shown earlier
$availableTimeSlots = [];

if (isset($dentistId)) {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT SlotID, SlotDateTime FROM TimeSlots WHERE DentistID = ? AND IsBooked = 0 AND SlotDateTime > NOW() ORDER BY SlotDateTime");
    $stmt->bind_param("i", $dentistId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $availableTimeSlots[] = $row;
    }

    $stmt->close();
}

// Now you have $availableTimeSlots containing all the available slots for the dentist
?>