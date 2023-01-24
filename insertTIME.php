<?php
function insertTIME($id,$date,$hour,$minute,$second){
    require "connect_db.php";
    mysqli_query($link, "insert into time_db values($id,$date,$hour,$minute,$second)");
}
?>