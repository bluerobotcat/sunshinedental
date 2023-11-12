<?php

function getPatientAppointments($patientId, $conn) {
    $appointments = [];
    $stmt = $conn->prepare("SELECT * FROM Appointments WHERE PatientID = ?");
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }

    $stmt->close();
    return $appointments;
}

?>