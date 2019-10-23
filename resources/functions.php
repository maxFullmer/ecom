<?php

// helper functions

function redirect($location) {
header("Location: $location ");
};

function query($sql) {
global $connection;

return mysqli_query($connection, $sql);
}

function confirm($result) {
global $connection;

// see if something is wrong with the query or the connection
if(!$result) {
die("QUERY FAILED" . mysqli_error($connection));
};

}

function escape_string($string) {
global $connection;
return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result) {
return mysqli_fetch_array($result);
}

/* -------------------FRONT END FUNCTIONS----------------- */

// database call 1: fetch products
function get_products() {

$products = query("SELECT * FROM products");
confirm($products);

while($row = fetch_array($products)) {

$_SESSION['current_product_id'] = $row['product_id'];

ob_start();
include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
$add_to_cart_button = ob_get_contents();
ob_end_clean();

ob_start();
include(TEMPLATE_FRONT . DS . "rating_total.php");
$rating_total = ob_get_contents();
ob_end_clean();

$product = <<<DELIMETER_PRODS

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="Product"></a>
        <div class="caption">
            <h4 class="pull-right">\${$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>{$row['product_description_short']}</p>
        </div>

        <!-- Add to cart button -->
        {$add_to_cart_button}

        <!-- ratings bar -->
        {$rating_total}
    </div>
</div>

DELIMETER_PRODS;

echo $product;
};
}

function get_single_product() {

$product = query(" SELECT * FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
confirm($product);

while($row = fetch_array($product)) {

$_SESSION['current_product_id'] = $row['product_id'];

ob_start();
include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
$add_to_cart_button = ob_get_contents();
ob_end_clean();

ob_start();
include(TEMPLATE_FRONT . DS . "rating_total.php");
$rating_total = ob_get_contents();
ob_end_clean();

$product_alone = <<<DELIMETER_PROD

<div class="col-md-9">

<!--Row For Image and Short Description-->

<div class="row">

<div class="col-md-7">
       <img class="img-responsive" src="http://placehold.it/700x600" alt="">

    </div>

    <div class="col-md-5">

        <div class="thumbnail">
         

    <div class="caption-full">
        <h4><a href="#">{$row['product_title']}</a> </h4>
        <hr>
        <h4 class="">\${$row['product_price']}</h4>

    <!-- ratings -->
    {$rating_total}
      
        <p>{$row['product_description']}</p>

    {$add_to_cart_button}


    </div>
 
</div>

</div>

</div><!--Row For Image and Short Description-->




<hr>


<!--Row for Tab Panel-->

<div class="row">

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

<p></p>
           
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>


    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>

    </div>
    <div role="tabpanel" class="tab-pane" id="profile">

  <div class="col-md-6">

       <h3>2 Reviews From </h3>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">10 days ago</span>
                <p>This product was great in terms of quality. I would definitely buy another!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">12 days ago</span>
                <p>I've alredy ordered another one!</p>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                Anonymous
                <span class="pull-right">15 days ago</span>
                <p>I've seen some better than this, but not at this price. I definitely recommend this item.</p>
            </div>
        </div>

    </div>


    <div class="col-md-6">
        <h3>Add A review</h3>

     <form action="" class="form-inline">
        <div class="form-group">
            <label for="">Name</label>
                <input type="text" class="form-control" >
            </div>
             <div class="form-group">
            <label for="">Email</label>
                <input type="test" class="form-control">
            </div>

        <div>
            <h3>Your Rating</h3>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
        </div>

            <br>
            
             <div class="form-group">
             <textarea name="" id="" cols="60" rows="10" class="form-control"></textarea>
            </div>

             <br>
              <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="SUBMIT">
            </div>
        </form>

    </div>

 </div>

 </div>

</div>

</div><!--Row for Tab Panel-->

</div>

DELIMETER_PROD;

echo $product_alone;
};

}

// database call 3: fetch categories
function get_categories() {
// ask for something from database
$categories = query("SELECT * FROM categories");
confirm($categories);

// extract the values from each row (best to have 1 column/field for each table in db)
while($row = fetch_array($categories)) {
$category_link = <<<DELIMETER_CAT

<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER_CAT;

echo $category_link;
};

}

/* -------------------BACK END FUNCTIONS----------------- */
?>