<?php
session_start();

include 'connection.php';

// initializing variables
$errors = array(); 

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  //$contact = mysqli_real_escape_string($conn, (int)$_POST['contact']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($firstname)) { array_push($errors, "First Name is required"); }
  if (empty($lastname)) { array_push($errors, "Last Name is required"); }
  //if (empty($contact)) { array_push($errors, "Contact Number is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
 array_push($errors, "The two passwords do not match");
  }


// Check if the email already exists in the database
$checkQuery = "SELECT * FROM dentists  WHERE email = '$email'";
$result = mysqli_query($conn, $checkQuery);

if (mysqli_num_rows($result) > 0) {
    // Email already exists, handle accordingly (e.g., show an error message)
    array_push($errors, "email already exists");
} else {
    // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
   $password = md5($password_1);//encrypt the password before saving in the database

   $query = "INSERT INTO dentists (firstname, lastname,email, password) 
       VALUES('$firstname','$lastname', '$email', '$password')";
   mysqli_query($conn, $query);
   $_SESSION['firstname'] = $firstname;
   $_SESSION['success'] = "You are now logged in";
   header('location: registersuccess.html');
  }
}
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  if (empty($email)) {
   array_push($errors, "Email is required");
  }
  if (empty($password)) {
   array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
   $password = md5($password);
   $query = "SELECT * FROM dentists WHERE email='$email' AND password='$password'";
   $results = mysqli_query($conn, $query);
   if (mysqli_num_rows($results) == 1) {
     $_SESSION['email'] = $email;
     $_SESSION['success'] = "You are now logged in";
      header('location: dentist_dashboard.php');

      // $_SESSION['DentistID'] = $user['DentistID'];
      // $_SESSION['FirstName'] = $user['FirstName'];
      // $_SESSION['LastName'] = $user['LastName'];
      // $_SESSION['Email'] = $user['Email'];
      // $_SESSION['Password'] = $user['Password'];
     
   }else {
    array_push($errors, "Wrong email/password combination");
   }
  }
} 

?>