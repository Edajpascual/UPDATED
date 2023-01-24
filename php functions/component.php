<?php

function component($productname,$productprice,$productimg,$product_id,$item_facts){
    $element = "<div class=\"col-md-3 col-sm-6 my-3 my-md-0\">
            <form action=\"user_home.php\" method=\"post\">
              <div class=\"card shadow\">
                <div>
                  <img src=\"$productimg\" class=\"img-fluid card-img-top\">
                </div>
                <div class=\"card-body\">
                  <h5 class=\"card-title\">$productname</h5>
                  <p class=\"card-text\">
                    $item_facts
                  </p>
                  <h5>
                    <span class=\"price\">₱
                    $productprice                    
                    </span>
                  </h5>
                  <button type=\"submit\" name=\"bid\" class=\"btn btn-primary my-3\">Bid</button>
                  <input type='hidden' name='product_id' value='$product_id'>
                </div>
              </div>
            </form>
          </div>";
          echo $element;
}
?>