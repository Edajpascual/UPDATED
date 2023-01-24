<?php

function viewuser($id){
    $element = "<div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
            <form action=\"admin_verify.php\" method=\"post\">
                  <button type=\"submit\" name=\"view\" class=\"btn btn-success\">View</button>
                  <input type='hidden' name='userID' value='$id'>
            </form>
          </div>";
          echo $element;
}
?>

