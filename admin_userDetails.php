<?php
include "connect_db.php";

require_once('admin_session.php');

$admin = $_SESSION['username'];
$user = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>User Details</title>
</head>

<div class="container">
    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="logo.PNG" alt="logo of ahs" width="40" height="32">       
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="admin_verify.php" class="nav-link px-2 link-dark">Users</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Items</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="">Help</a></li>
            <li><a class="dropdown-item" href="">Settings</a></li>
            <li><a class="dropdown-item" href="">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="user_logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>

    <h1>WELCOME 
     <?php
     $res=mysqli_query($link, "SELECT admin_name, admin_id FROM admin_db WHERE admin_username = '$admin' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          echo $row["admin_name"]; echo " "; echo $row["admin_id"];  
        }
      }  
    ?>
    </h1>

    <?php
          $res=mysqli_query($link, "SELECT id, firstname, lastname, email, age, address, contact, account_status from users_db WHERE id = '$user' ");
          if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
              echo "<p>User name: "; echo "</p>"; echo "<h2>"; echo $row["firstname"] . " ";  echo $row["lastname"]; echo "</h2>";
              echo "<p>Email: "; echo "</p>"; echo "<h2>"; echo $row["email"]; echo "</h2>"; 
              echo "<p>Age: "; echo "</p>"; echo "<h2>"; echo $row["age"]; echo "</h2>";
              echo "<p>Address: "; echo "</p>"; echo "<h2>"; echo $row["address"]; echo "</h2>"; 
              echo "<p>Contact: "; echo "</p>"; echo "<h2>"; echo $row["contact"]; echo "</h2>"; 
            }
          }  
    ?>

    <?php
    $res=mysqli_query($link, "SELECT gov_id1, gov_id2, id1_type, id2_type from verify_db WHERE user_id = '$user' ");
    if(mysqli_num_rows($res) > 0) {
      while($row = mysqli_fetch_assoc($res)) {
        echo "<p>1st Government ID Type: "; echo "</p>"; echo "<h2>"; echo $row["id1_type"]; echo "</h2>";
        
        $extract_id1 = $row["gov_id1"];
        $id1 = explode(" ", $extract_id1);
        foreach($id1 as $data){
          ?> <img src="user_governmentIDs/<?php echo $data?>" width="310" height="230"><?php
          echo $data;
          echo "<br>";
          echo "<br>";
        }

        echo "<p>2nd Government ID Type: "; echo "</p>"; echo "<h2>"; echo $row["id2_type"]; echo "</h2>";

        $extract_id2 = $row["gov_id2"];
        $id2 = explode(" ", $extract_id2);
        foreach($id2 as $data){
          ?> <img src="user_governmentIDs/<?php echo $data?>" width="310" height="230"><?php
          echo $data;
          echo "<br>";
          echo "<br>";
        }
      }
    }  
    ?>

<form action="" name="post_form" method="POST">  
  <button type="submit" class="btn btn-primary" name="verify_request">Verify</button>
  <button type="submit" class="btn btn-primary" name="deny_verification">Deny</button>
  <br>
  <br>
</form>

<?php
    if(isset($_POST["verify_request"])){
      $new_status= 1;
      mysqli_query($link, "UPDATE users_db SET account_status='$new_status' WHERE id='$user'");

        ?> 
        <script>
         window.alert("Account Verified");
         window.location.assign("admin_verify.php");
        </script>
        <?php  
      }     
?>



    