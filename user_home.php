<?php
include "connect_db.php";
require_once('./php functions/component.php');
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
    <link rel="stylesheet" href="items.css">
   

    <title>Home</title>
</head>

<body>
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
          <li><a href="user_notebook.php" class="nav-link px-2 link-dark">Notebook</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
        </ul>

        <form action="user_home.php" method="POST" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
          <input type="text" name="search" class="form-control" placeholder="Search...">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="">Help</a></li>
            <li><a class="dropdown-item" href="">Settings</a></li>
            <li><a class="dropdown-item" href="profilepage.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="user_logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
    <h1>WELCOME 
     <?php
     $res=mysqli_query($link, "SELECT firstname, lastname, account_status FROM users_db WHERE email = '$myemail' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          echo $row["firstname"]; echo " "; echo $row["lastname"];
          $status = $row["account_status"];
          if($status==0){
            echo "<h3>"; echo " UNVERIFIED "; echo "</h3>"; 
          }
          else
          {
            echo "<h3>"; echo " VERIFIED "; echo "</h3>";
          }
        }
      }  
    ?>
    </h1>

    <div class="container">
        <div class="row text-center py-5">
            <?php
            $res=mysqli_query($link, "SELECT item_number, item_name, item_photo, asking_price, item_status, auction_endtime, item_facts from items_db");
            while($row=mysqli_fetch_array($res)){
              $checktime = $row['auction_endtime'];
              $time_status = strtotime($checktime);
              $localtime = date("Y-m-d\TH:i:sP");
              $now = strtotime($localtime); 
              if($row['item_status']==1 && ($time_status)>($now)){
              component($row['item_name'], $row["asking_price"], $row["item_photo"], $row['item_number'],$row['item_facts']);
              }
            }
            if(isset($_POST['bid'])){
              if($status<1){
              ?>
              <script>window.alert("Account Not Verified")
              window.location.assign("verification.php")
              </script><?php  
              }
              $items_id = $_POST['product_id'];
              $_SESSION["item_number"] = $items_id;
              ?>
              <script>window.location.assign("bid_ITEMpage.php")</script><?php
            }
              
            ?>

<?php
    
    if(isset($_POST['search']))
    {
      $searchITEM = $_POST['search'];
      $_SESSION['search'] = $searchITEM;
      ?>
      <script>window.location.assign("search.php")</script>
      <?php
  }

    ?>
        </div>
    </div>

    </div>
</body>
</html>