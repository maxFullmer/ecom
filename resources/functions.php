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

ob_start();
include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
$add_to_cart_button = ob_get_contents();
ob_end_clean();

ob_start();
include(TEMPLATE_FRONT . DS . "rating_bar.php");
$rating_bar = ob_get_contents();
ob_end_clean();

$products = query("SELECT * FROM products");
confirm($products);

while($row = fetch_array($products)) {

$product = <<<DELIMETER_PROD

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="Product"></a>
        <div class="caption">
            <h4 class="pull-right">\${$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
            </h4>
            <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>

        <!-- Add to cart button -->
        {$add_to_cart_button}

        <!-- ratings bar -->
        {$rating_bar}
    </div>
</div>

DELIMETER_PROD;

echo $product;
};

}

// database call 2: fetch categories
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