<?php
include "connect_db.php";
require_once('admin_session.php');
require_once('test.php');
$admin = $_SESSION['username'];
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
            <li><a class="dropdown-item" href="profilepage.php">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="admin_logout.php">Sign out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
    <h1>WELCOME admin 
     <?php
     $res=mysqli_query($link, "SELECT admin_name, admin_id FROM admin_db WHERE admin_username = '$admin' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          echo $row["admin_name"]; echo "#"; echo $row["admin_id"];
        }
      }  
    ?>
    </h1>

    <table class="table table-image">
    <tr>
      <th>User ID</th>
      <th>User Name (SELLER)</th>
      <th>Item</th>
      <th>Account Status</th>
      <th>Accept</th>
      <th>Deny</th>
    </tr>
    <?php
     $res=mysqli_query($link, "SELECT item_number, item_name, item_photo, asking_price, item_status, account_status, id , firstname, lastname from items_db, users_db WHERE users_db.id = items_db.seller_id");
     while($row=mysqli_fetch_array($res)){
      if($row['item_status'] == 0){
      if($row["account_status"]==1){
      $row["account_status"]="good";
      echo "<tr>";
      echo "<td>"; echo $row["id"]; echo "</td>";
      echo "<td>"; echo $row["firstname"] . " ";  echo $row["lastname"]; echo "</td>";
      echo "<td class=\"w-25\">"; ?> <img src="<?php echo $row["item_photo"];?>" class="img-fluid img-thumbnail"> <?php echo "<p>Item name: ";echo $row["item_name"]; echo "</p>"; echo "</td>";
      echo "<td>"; echo $row["account_status"]; echo "</td>";
      echo "<td>"; 
      
      postmodule($row["item_number"]);
    
      echo "</td>";
      echo "<td>"; denymodule($row["item_number"]); echo "</td>";
      echo "</tr>";   
     }
     else{
      $row["account_status"]="bad";
      echo "<tr>";
      echo "<td>"; echo $row["id"]; echo "</td>";
      echo "<td>"; echo $row["firstname"] . " ";  echo $row["lastname"]; echo "</td>";
      echo "<td class=\"w-25\">"; ?> <img src="<?php echo $row["item_photo"];?>" class="img-fluid img-thumbnail"> <?php echo "<p>Item name: ";echo $row["item_name"]; echo "</p>"; echo "</td>";
      echo "<td>"; echo $row["account_status"]; echo "</td>";
      echo "<td>"; 
      
      postmodule($row["item_number"]);
    
      echo "</td>";
      echo "<td>"; denymodule($row["item_number"]); echo "</td>";
      echo "</tr>";   
     }
    }
    }
    ?>

    </table>
    <?php
    if(isset($_POST['accept'])){
        $id = $_POST['item_id'];
        $_SESSION["item_number"] = $id;
        ?>
        <script>window.location.assign("admin_post.php")</script><?php
      } ?>

<?php
    if(isset($_POST['deny'])){
      $id = $_POST['item_id'];
      $new_status=3;
      mysqli_query($link, "UPDATE items_db SET item_status='$new_status' WHERE item_number='$id'"); 
      ?> <script>window.location.assign("admin_home.php")</script> <?php
      } 
      ?>
    </div>
</body>
</html>