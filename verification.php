<?php
include "connect_db.php";
require_once('session.php');
$myemail = $_SESSION['email'];
?>

<?php
     $res=mysqli_query($link, "SELECT id FROM users_db WHERE email = '$myemail' ");
     if(mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
          $user_id = $row['id'];
        }
      }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <title>Account Verification</title>
</head>
<body>
    <div class="container">
        <h1>VERIFICATION</h1>
    <form action="" name="verify_form" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <p>Enter Two Government Issued Identification (ID)
  </div>
  <div class="mb-3">
    <h4>Select ID type for photo 1 :</h4>
    <input type="radio" id="drivers" name="gov_ID1" value="DriversLicense">
    <label for="drivers">Driver's License</label><br>
    <input type="radio" id="national" name="gov_ID1" value="National ID">
    <label for="national">National ID</label><br>
    <input type="radio" id="UMID" name="gov_ID1" value="UMID">
    <label for="UMID">UMID</label><br>
  </div>
  
  <div class="form-group">
   <label for="frontgov_id1" class="form-label">Government ID PHOTO 1 Front:</label>
    <input type="file" class="form-control" name="frontgov_id1">
  </div>
  <div class="form-group">
  <label for="backgov_id1" class="form-label">Government ID PHOTO 1 Back:</label>
    <input type="file" class="form-control" name="backgov_id1">
  </div>

  <br>

  <div class="mb-3">
    <h4>Select ID type for photo 2 :</h4>
    <input type="radio" id="drivers" name="gov_ID2" value="Driver's License">
    <label for="drivers">Driver's License</label><br>
    <input type="radio" id="national" name="gov_ID2" value="National ID">
    <label for="national">National ID</label><br>
    <input type="radio" id="UMID" name="gov_ID2" value="UMID">
    <label for="UMID">UMID</label><br>
  </div>
  
  <div class="form-group">
   <label for="frontgov_id2" class="form-label">Government ID PHOTO 2 Front:</label>
    <input type="file" class="form-control" name="frontgov_id2">
  </div>
  <div class="form-group">
  <label for="backgov_id2" class="form-label">Government ID PHOTO 2 Back:</label>
    <input type="file" class="form-control" name="backgov_id2">
  </div>

  <br>

  <button type="submit" class="btn btn-primary" name="register">Verify</button>
</form>

    <?php
    if(isset($_POST["register"])){
      $id_type1=$_POST['gov_ID1'];
      $id_type2=$_POST['gov_ID2'];
      $location="user_governmentIDs/";

      $file1=$_FILES['frontgov_id1']['name'];
      $file_tmp1=$_FILES['frontgov_id1']['tmp_name'];

      $file2=$_FILES['backgov_id1']['name'];
      $file_tmp2=$_FILES['backgov_id1']['tmp_name'];

      $data1=[];
      $data1=[$file1,$file2];
      $photo_ID1=implode(' ',$data1);

      $file3=$_FILES['frontgov_id2']['name'];
      $file_tmp3=$_FILES['frontgov_id2']['tmp_name'];

      $file4=$_FILES['backgov_id2']['name'];
      $file_tmp4=$_FILES['backgov_id2']['tmp_name'];

      $data2=[];
      $data2=[$file3,$file4];
      $photo_ID2=implode(' ',$data2);
      
      mysqli_query($link, "insert into verify_db values(NULL,'$user_id','$photo_ID1','$photo_ID2','$id_type1','$id_type2','0')");
      move_uploaded_file($file_tmp1, $location.$file1);
      move_uploaded_file($file_tmp2, $location.$file2);
      move_uploaded_file($file_tmp3, $location.$file3);
      move_uploaded_file($file_tmp4, $location.$file4);
      ?> <script>
      window.alert("Account verification to be reviewed.")
      window.location.assign("user_home.php")
      </script> <?php
    }
    ?>

</body>
</html>