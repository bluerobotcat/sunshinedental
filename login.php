<?php
session_start(); // Start a new session or resume the existing one

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection script
    include 'connection.php';

    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = md5($password);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT PatientID, FirstName, LastName, ContactInfo, Password FROM Patients WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
                // // Debugging: Output the user data
                // echo "User Data: " . print_r($user, true) . "<br>";

    //    $storedHashedPassword = $user['Password']; // Make sure it matches the column name in your database

       $password = md5($password);
       // Compare the hashed entered password with the stored hash
    if ($hashedEnteredPassword === $storedPasswordHash) {
            // Password is correct, so start a new session
            $_SESSION['loggedin'] = true;
            $_SESSION['PatientID'] = $user['PatientID'];
            $_SESSION['FirstName'] = $user['FirstName'];
            $_SESSION['LastName'] = $user['LastName'];
            $_SESSION['ContactInfo'] = $user['ContactInfo'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['Password'] = $user['Password'];

            // Redirect the user to their dashboard or homepage
            header("Location: dashboard.php");
            exit;
        } else {
            // If the password is not correct
            $error = "The password you entered was not valid.";
        }
    } else {
        // If the email doesn't exist
        $error = "No account found with that email address.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Your HTML login form goes here -->

<!-- You can display an error message if needed -->
<?php if (!empty($error)): ?>
<div class="alert alert-danger" role="alert">
    <?php echo $error; ?>
</div>
<?php endif; ?>
