<?php
include 'connnection.php';

$dentists = [];
$query = "SELECT DentistID, FirstName, LastName, Specialization FROM Dentists";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $dentists[] = $row;
}

$conn->close();
?>