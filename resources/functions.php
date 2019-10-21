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

// get_products

function get_products() {

// prep components to work within HEREDOC
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

$product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
    <div class="thumbnail">
        <a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt="Product"></a>
        <div class="caption">
            <h4 class="pull-right">\${$row['product_price']}</h4>
            <h4><a href="item.php?id={$row['product_image']}">{$row['product_title']}</a>
            </h4>
            <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>

        <!-- Add to cart button -->
        {$add_to_cart_button}

        <!-- ratings bar -->
        {$rating_bar}
    </div>
</div>

DELIMETER;

echo $product;
};

}

?>