<?php

function search($productname,$productprice,$productimg,$product_id,$item_facts){
    $element = "<div class=\"col-md-7 col-sm-6 my-3 my-md-0\">
            <form action=\"search.php\" method=\"post\">
        <div class=\"row\">
            <div class=\"col p-3\"><img src=\"$productimg\" class=\"img-fluid card-img-top\"> </div>  
            <div class=\"col p-3\"><h5>$productname</h5><p>$item_facts</p></div> 
            <div class=\"col p-3\"><h5>₱$productprice</h5>    
            <button type=\"submit\" name=\"bid_search\" class=\"btn btn-primary my-3 \">Bid</button>
            <input type='hidden' name='product_id' value='$product_id'></div>
            </div>
            </form>
          </div>";
          echo $element;
}
?>