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

/* -------------------FRONT END FUNCTIONS/SSR----------------- */

// SSR 1: fetch products for index.php (home page)
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

    $product_stub = <<<DELIMETER_PRODS

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

    echo $product_stub;
    };
}

// SSR 2: fetch single product for item.php (product page)
function get_single_product() {

    $get_product = query(" SELECT * FROM products WHERE product_id =" . escape_string($_GET['id']) . " ");
    confirm($get_product);

    $product = fetch_array($get_product);

    // send data to be used for description tag
    $_SESSION['current_product_description_long'] = $product['product_description_long'];
    // allow data to be used for rating bar
    $_SESSION['current_product_id'] = $_GET['id'];

    ob_start();
    include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
    $add_to_cart_button = ob_get_contents();
    ob_end_clean();

    ob_start();
    include(TEMPLATE_FRONT . DS . "rating_total.php");
    $rating_total = ob_get_contents();
    ob_end_clean();

    $product_stub_alone = <<<DELIMETER_PROD

<div class="col-md-7">
    <img class="img-responsive" src="{$product['product_image']}" alt="Product">
</div>

<div class="col-md-5">

    <div class="thumbnail">
        
    <div class="caption-full">
        <h4><a href="#">{$product['product_title']}</a> </h4>
        <hr>
        <h4 class="">\${$product['product_price']}</h4>

        <!-- ratings -->
        {$rating_total}
    
        <p>{$product['product_description_short']}</p>

        {$add_to_cart_button}

    </div>

    </div>

</div>

DELIMETER_PROD;

    echo $product_stub_alone;

}

function get_product_description_long() {

$description_pane = "
    <p></p>
    <p>{$_SESSION['current_product_description_long']}</p>
";

    echo $description_pane;
}

// SSR call 4: ratings and reviews
function get_product_reviews() {

    $ratings = query("SELECT * FROM ratings WHERE rating_product_id =" . escape_string($_SESSION['current_product_id']) . " ");
    confirm($ratings);

    if (fetch_array($ratings) === NULL) {
        echo "<hr><div class='row'><p></p><p>This product has no reviews yet!</p></div>";
    }
    else {
        echo "<div class='col-md-6'>";
        while($rating = fetch_array($ratings)) {
            
            $_SESSION['current_rating_value'] = $rating['rating_value'];
            $rating_date_yyyymmdd = substr($rating['rating_date'],0,10);

            ob_start();
            include(TEMPLATE_FRONT . DS . "rating_individual.php");
            $rating_individual = ob_get_contents();
            ob_end_clean();

            $rating_and_review = <<<DELIMETER_PROD_REVIEWS

<hr>

<div class="row">
    <div class="col-md-12">
        {$rating_individual}
        {$rating['rating_rater']}
        
        <span class="pull-right">{$rating_date_yyyymmdd}</span>
        <p>{$rating['rating_product_review']}</p>
    </div>
</div>

DELIMETER_PROD_REVIEWS;
        echo $rating_and_review;
        }
        echo "</div>";
    }
    $rating_and_review_form = <<<DELIMETER_RR_FORM

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

DELIMETER_RR_FORM;

    echo $rating_and_review_form;
    
}

// SSR call 5: fetch categories
function get_categories() {

    $categories = query("SELECT * FROM categories");
    confirm($categories);

    while($row = fetch_array($categories)) {

    $category_link = <<<DELIMETER_CAT

<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>

DELIMETER_CAT;

    echo $category_link;
    };

}

function get_products_by_category() {

    $products_by_category = query("SELECT * FROM products WHERE product_category_id =" . escape_string($_GET['id']) . " ");
    confirm($products_by_category);

    while($product_by_cat = fetch_array($products_by_category)) {
        $product_by_cat_HTML = <<<DELIMETER_PROD_BY_CAT

<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$product_by_cat['product_image']}" alt="">
        <div class="caption">
            <h3>{$product_by_cat['product_title']}</h3>
            <p>{$product_by_cat['product_description_short']}</p>
            <p>
                <a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>

DELIMETER_PROD_BY_CAT;

        echo $product_by_cat_HTML;
    }
}

function get_products_for_shop_page() {

    $products_for_shop_page = query("SELECT * FROM products WHERE product_category_id =" . escape_string($_GET['id']) . " ");
    confirm($products_for_shop_page);

    while($product_for_shop_page = fetch_array($products_for_shop_page)) {
        $product_for_shop_page_HTML = <<<DELIMETER_PROD_BY_CAT

<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$product_for_shop_page['product_image']}" alt="">
        <div class="caption">
            <h3>{$product_for_shop_page['product_title']}</h3>
            <p>{$product_for_shop_page['product_description_short']}</p>
            <p>
                <a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>

DELIMETER_PROD_BY_CAT;

        echo $product_by_cat_HTML;
    }
}
/* -------------------BACK END FUNCTIONS----------------- */
?>