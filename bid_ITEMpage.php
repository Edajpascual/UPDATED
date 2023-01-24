<?php
include "connect_db.php";

require_once('session.php');

$myemail = $_SESSION['email'];
$items_id = $_SESSION['item_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Bidding</title>
</head>

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

  <h1>WELCOME 
     <?php
     $res=mysqli_query($link, "SELECT firstname, lastname, id FROM users_db WHERE email = '$myemail' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          echo $row["firstname"] . $row["lastname"];
          $user_id = $row["id"];
        }
      }  
    ?>
    </h1>

    <?php
          $res=mysqli_query($link, "SELECT item_name, item_photo, asking_price, seller_id, item_facts from items_db WHERE item_number = '$items_id'");
          if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
              echo "<p>Item name:"; echo "</p>"; echo "<h2>"; echo $row["item_name"]; echo "</h2>"; echo " "; 
              echo "<p>Starting bid price:"; echo "</p>"; echo "<h2>"; echo $row["asking_price"]; echo "</h2>"; echo " "; 
              echo "<div>";?> <img src=<?php echo $row["item_photo"];?> width="310" height="230">
             <?php 
              echo "<p>Item Description: "; echo "</p>"; echo "<h2>"; echo $row["item_facts"]; echo "</h2>";
             $seller_id=$row["seller_id"];
            }
          }  
    ?>


    <form action="" name="bid_form" method="POST">
  <div class="mb-3">
    <label for="price" class="form-label">Enter your bid:</label>
    <input type="price" class="form-control" id="price" aria-describedby="discription" name="price" required>
    <div id="discription" class="form-text">Please enter bid in digits form</div>
  </div>
  
  <button type="submit" class="btn btn-primary" name="auction">Auction</button>
</form>

<?php
    if(isset($_POST["auction"])){
      $res=mysqli_query($link, "SELECT item_number from items_db WHERE item_number = '$items_id' AND seller_id = '$user_id'");
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
      $count = mysqli_num_rows($res);
      
      $res=mysqli_query($link, "SELECT item_number from bids_db WHERE item_number = '$items_id' AND bidder_id = '$user_id'");
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
      $confirm = mysqli_num_rows($res); 

      $res=mysqli_query($link, "SELECT auction_endtime from items_db WHERE item_number = '$items_id'");
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
      $checktime = $row['auction_endtime'];
      $time_status = strtotime($checktime);
      $localtime = date("Y-m-d\TH:i:sP");
      $now = strtotime($localtime); 
      
      $res=mysqli_query($link, "SELECT asking_price from items_db WHERE item_number = '$items_id'");
      $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
      $eval_price = $row['asking_price'];
      $bid = $_POST['price'];

      if(($time_status)<($now)){ 
        ?> 
        <script>
         window.alert("Auction Ended");
         window.location.assign("user_home.php");
        </script>
        <?php  
      }
      elseif($count == 1){ 
          ?> 
          <script>
           window.alert("You cannot bid on your own item");
           window.location.assign("user_home.php");
          </script>
          <?php  
      }
      elseif ($confirm == 1){    
          ?> 
          <script>
           window.alert("You can only bid once");
           window.location.assign("user_home.php");
          </script>
          <?php  
      }
      elseif (($bid) < ($eval_price)){    
        ?> 
        <script>
         window.alert("Bid not accepted, must be higher than asking price");
         window.location.assign("user_home.php");
        </script>
        <?php  
      }        
      else{  
        mysqli_query($link, "INSERT into bids_db values(NULL,'$user_id','$_POST[price]','$seller_id','$items_id')");

        $res=mysqli_query($link, "SELECT bid_result from items_db WHERE item_number = '$items_id'");
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $bid_result = $row['bid_result'];

        if($bid>$bid_result){
        mysqli_query($link, "UPDATE items_db SET winner_id='$user_id', bid_result='$bid' WHERE item_number='$items_id'");
        }

        ?> 
        <script>
         window.alert("Bid accepted, you will be notified on <?php echo $checktime; ?>");
         window.location.assign("user_home.php");
        </script>
        <?php  
      }     
      ?>
      <?php
    }
?>
   

