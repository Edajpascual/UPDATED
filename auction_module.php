<?php
include "connect_db.php";
require_once('insertTIME.php');
require_once('session.php');

$myemail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Auction Form</title>
</head>
<body>
<?php


$res=mysqli_query($link, "SELECT id FROM users_db WHERE email = '$myemail' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $seller_id = $row["id"];
        }
      }  
      $availability=true;
?>

<div class="container">
    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="user_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="logo.PNG" alt="logo of ahs" width="40" height="32">       
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="bid_module.php" class="nav-link px-2 link-secondary">Bid</a></li>
          <li><a href="auction_module.php" class="nav-link px-2 link-dark">Auction</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Notebook</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
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

<div class="container">
    <form action="" name="register_form" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="itemname" class="form-label">Item:</label>
    <input type="text" class="form-control" id="itemname" placeholder="Enter item name" name="itemname">
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">Image:</label>
    <input type="file" class="form-control" name="image">
  </div>
  
  <div class="mb-3">
    <label for="price" class="form-label">Asking Price:</label>
    <input type="price" class="form-control" id="price" aria-describedby="discription" name="price">
    <div id="discription" class="form-text">Please enter starting price in digits form</div>
  </div>

  <div class="mb-3">
    <label for="end_dt" class="form-label">Date-Time of Auction End:</label>
    <input type="datetime-local" class="form-control" name="end_dt">
  </div>
  
  <button type="submit" class="btn btn-primary" name="auction">Auction</button>
</form>
<?php
    if(isset($_POST["auction"])){
        $tm=md5(time());
        $fnm=$_FILES["image"]["name"];
        $dst="./item_images/".$tm.$fnm;
        $dst1="item_images/".$tm.$fnm;
        move_uploaded_file($_FILES["image"]["tmp_name"],$dst);
        $status = 0;

        mysqli_query($link, "insert into items_db values(NULL,'$_POST[itemname]','$dst1','$_POST[price]','$seller_id','$availability','$_POST[end_dt]',NULL,NULL,'$status','')");

        ?>
        <script>
          window.alert("Item accepted for quality checking, you will be notified when is accepted for auction");
          window.location.assign("user_home.php");
        </script>
        <?php
    }

    // $res=mysqli_query($link, "SELECT DATE(auction_endtime), HOUR(auction_endtime), MINUTE(auction_endtime), SECOND(auction_endtime), item_number from items_db");
    //         while($row=mysqli_fetch_array($res)){
    //           insertTIME($row['item_number'],$row['DATE(auction_endtime)'],$row['HOUR(auction_endtime)'], $row['MINUTE(auction_endtime)'],$row['SECOND(auction_endtime)']);
    //         }
?>
</div>

</body>
</html>

