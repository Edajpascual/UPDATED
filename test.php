<?php

function postmodule($product_id){
    $element = "<div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
            <form action=\"admin_home.php\" method=\"post\">
                  <button type=\"submit\" name=\"accept\" class=\"btn btn-success\">Post</button>
                  <input type='hidden' name='item_id' value='$product_id'>
            </form>
          </div>";
          echo $element;
}

function denymodule($product_id){
      $element = "<div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
            <form action=\"admin_home.php\" method=\"post\">
                  <button type=\"submit\" name=\"deny\" class=\"btn btn-danger\">Deny</button>
                  <input type='hidden' name='item_id' value='$product_id'>
            </form>
          </div>";
          echo $element;
}

?>
