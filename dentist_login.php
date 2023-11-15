<?php include('server_d.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login for In-House Dentists</title>
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
            <h2 class="section-heading">Login for In-House Dentists</h2>
  <form method="post" action="dentist_login.php">
   <?php include('errors.php'); ?>
   <div class="input-group">
    <label>Email</label>
    <input type="text" name="email" >
   </div>
   <div class="input-group">
    <label>Password</label>
    <input type="password" name="password">
   </div>
   <div class="input-group">
    <button type="submit" class="btn" name="login_user">Login</button>
   </div>
   <p>
    Not yet a member? <a href="register_d.php">Sign up</a>
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