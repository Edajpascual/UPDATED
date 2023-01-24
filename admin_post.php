<?php
include "connect_db.php";

require_once('admin_session.php');

$admin = $_SESSION['username'];
$id = $_SESSION['item_number'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Admin Post</title>
</head>

<div class="container">
    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="admin_home.php" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <img src="logo.PNG" alt="logo of ahs" width="40" height="32">       
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="bid_module.php" class="nav-link px-2 link-secondary">Bid</a></li>
          <li><a href="auction_module.php" class="nav-link px-2 link-dark">Auction</a></li>
          <li><a href="user_notebook.php" class="nav-link px-2 link-dark">Notebook</a></li>
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
     $res=mysqli_query($link, "SELECT admin_name, admin_id FROM admin_db WHERE admin_username = '$admin' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          echo $row["admin_name"]; echo " "; echo $row["admin_id"]; 
        }
      }  
    ?>
    </h1>

    <?php
          $res=mysqli_query($link, "SELECT item_number, item_name, item_photo, asking_price, item_status, seller_id, auction_endtime from items_db WHERE item_number = '$id'");
          if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
              echo "<p>Item name:"; echo "</p>"; echo "<h2>"; echo $row["item_name"]; echo "</h2>"; echo " "; 
              echo "<p>Selected starting bid price:"; echo "</p>"; echo "<h2> ₱ "; echo $row["asking_price"]; echo "</h2>"; echo " "; 
              echo "<p>Selected auction end time:"; echo "</p>"; echo "<h2>"; echo $row["auction_endtime"]; echo "</h2>"; echo " ";
              
              echo "<div>";?> <img src=<?php echo $row["item_photo"];?> width="310" height="230">
             <?php
             $seller = $row["seller_id"];
            }
          }  
    ?>

    <?php
          $res=mysqli_query($link, "SELECT id, firstname, lastname, account_status from users_db WHERE id = '$seller'");
          if(mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
              echo "</t>"; echo "<p>Seller name: "; echo "</p>"; echo "<h2>"; echo $row["firstname"] . ' ' . $row["lastname"]; echo "</h2>";
              if($row["account_status"]==0){
                $row["account_status"]="good";
                echo "<p>Account Status: "; echo $row["account_status"]; echo "</p>"; 
              }
              else if ($row["account_status"]==1){
                $row["account_status"]="bad";
              echo "<p>Account Status: "; echo $row["account_status"]; echo "</p>"; 
              }
            }
          }  
    ?>

<form action="" name="post_form" method="POST">
  <div class="mb-3">
    <label for="fact" class="form-label">Enter Item Description: </label>
    <input type="input" class="form-control" id="fact" aria-describedby="description" name="fact" required>
    <div id="description" class="form-text"></div>
  </div>
  
  <button type="submit" class="btn btn-primary" name="post_request">Accept Auction</button>
</form>

<?php
    if(isset($_POST["post_request"])){
      $new_status= 1;
      mysqli_query($link, "UPDATE items_db SET item_status='$new_status' WHERE item_number='$id'");

      mysqli_query($link, "UPDATE items_db SET item_facts='$_POST[fact]' WHERE item_number='$id'");
        ?> 
        <script>
         window.alert("Request Posted");
         window.location.assign("admin_home.php");
        </script>
        <?php  
      }     
?>