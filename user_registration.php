<?php
include "connect_db.php";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Registration</title>
</head>
<body>
    <div class="container">
    <form action="" name="register_form" method="POST">
  <div class="mb-3">
    <label for="firstname" class="form-label">Firstname:</label>
    <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname">
  </div>
  <div class="mb-3">
    <label for="lastname" class="form-label">Lastname:</label>
    <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname">
  </div>
  <div class="mb-3">
    <label for="age" class="form-label">Age:</label>
    <input type="number" class="form-control" id="age" placeholder="Enter Age" name="age" min="18">
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address:</label>
    <input type="text" class="form-control" id="address" placeholder="Enter Address" name="address">
  </div>
  <div class="mb-3">
    <label for="contact" class="form-label">Cellphone Number:</label>
    <input type="text" class="form-control" id="contact" placeholder="Enter phonenumber" name="contact">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email address:</label>
    <input type="email" class="form-control" id="email" aria-describedby="discription" name="email">
    <div id="discription" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="pwd" class="form-label">Password:</label>
    <input type="password" class="form-control" id="pwd" name="pwd">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="remember">
    <label class="form-check-label" for="remember">Remember me</label>
  </div>
  <button type="submit" class="btn btn-primary" name="register">Register</button>
</form>


<br><p>Already have an account?</p><a href="user_login.php">Login!</a>

    <?php
    if(isset($_POST["register"])){
      if($_POST["age"]<18){
        ?>
        <script>
          window.alert("Registration Failed, Age not allowed");
          window.location.assign("user_login.php");
        </script>
        <?php
      }
        mysqli_query($link, "insert into users_db values(NULL,'$_POST[firstname]','$_POST[lastname]','$_POST[email]','$_POST[pwd]',0,'$_POST[age]','$_POST[address]','$_POST[contact]')");
        ?>
        <script>
          window.alert("Registration Successful");
          window.location.assign("user_login.php");
        </script>
        <?php
    }
    ?>

</body>
</html>