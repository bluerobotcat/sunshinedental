<?php include('server_d.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Signup for In-House Dentists</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    form, .content {
  width: 30%;
  margin: 0px auto;
  padding: 20px;
  border: 1px solid #B0C4DE;
  background: white;
  border-radius: 0px 0px 10px 10px;
}
.input-group {
  margin: 10px 0px 10px 0px;
}
.input-group label {
  display: block;
  text-align: left;
  margin: 3px;
}
.input-group input {
  height: 30px;
  width: 93%;
  padding: 5px 10px;
  font-size: 16px;
  border-radius: 5px;
  border: 1px solid gray;
}
.btn {
  padding: 10px;
  font-size: 15px;
  color: white;
  background: #5F9EA0;
  border: none;
  border-radius: 5px;
}
.error {
  width: 92%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #a94442; 
  color: #a94442; 
  background: #f2dede; 
  border-radius: 5px; 
  text-align: left;
}
.success {
  color: #3c763d; 
  background: #dff0d8; 
  border: 1px solid #3c763d;
  margin-bottom: 20px;
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
        </div>
    </header>

    <main class="container">
        <section id="signup-form" class="section-background">
            <h2 class="section-heading">Signup for In-House Dentists</h2>
  <form method="post" action="register_d.php">
   <?php include('errors.php'); ?>
   <div class="input-group">
     <label>First Name</label>
     <input type="text" name="firstname">
   </div>
      <div class="input-group">
     <label>Last Name</label>
     <input type="text" name="lastname">
   </div>
      <!-- <div class="input-group">
     <label>Contact No.:</label>
     <input type="text" name="contact">
   </div> -->
   <div class="input-group">
     <label>Email</label>
     <input type="email" name="email">
   </div>
   <div class="input-group">
     <label>Password</label>
     <input type="password" name="password_1">
   </div>
   <div class="input-group">
     <label>Confirm password</label>
     <input type="password" name="password_2">
   </div>
   <div class="input-group">
     <button type="submit" class="btn" name="reg_user">Register</button>
   </div>
   <p>
    Already a member? <a href="dentist_login.php">Sign in</a>
   </p>
  </form>
  </section>
    </main>

    <!-- Footer -->
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
            <li><a href="dentist/register.php">Dentist Register</a></li>
          </ul>
        </nav>
        <p>&copy; 2023 Sunshine Dental Clinic. All rights reserved.</p>
      </div>
    </footer>
</body>
</html>