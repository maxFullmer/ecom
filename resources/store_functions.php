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

function set_message($msg){
    if(!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
    return $_SESSION['message'];
}

function display_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

/* -------------------FRONT END FUNCTIONS/SSR----------------- */

// SSR 1: fetch products for index.php (home page)
function get_products() {
    $products = query("SELECT * FROM products");
    confirm($products);

    while($row = fetch_array($products)) {

    $_SESSION['product_info'] = $row;

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
        <a href="item.php?product_id={$row['product_id']}"><img src="{$row['product_image']}" onerror="this.src='./backup_prod_img.png';" alt="Product"></a>
        <div class="caption-full">
            <h4 class="pull-right">\${$row['product_price']}</h4>
            <h4><a href="item.php?product_id={$row['product_id']}">{$row['product_title']}</a>
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
    $get_product = query(" SELECT * FROM products WHERE product_id =" . escape_string($_GET['product_id']) . " ");
    confirm($get_product);

    $product = fetch_array($get_product);

    $_SESSION['product_info'] = $product;

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
    <img class="img-responsive" src="{$product['product_image']}" onerror="this.src='./backup_prod_img.png';" alt="Product">
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
    <p>{$_SESSION['product_info']['product_description_long']}</p>
";

    echo $description_pane;
}

// SSR call 4: ratings and reviews
function get_product_reviews() {

    $ratings = query("SELECT * FROM ratings WHERE rating_product_id =" . escape_string($_SESSION['product_info']['product_id']) . " ");
    confirm($ratings);

    if (!$ratings) {
        echo "<hr><div class='row'><p></p><p>This product has no reviews yet!</p></div>";
    }
    else {
        echo "<div class='col-md-6'>";
        while($rating = fetch_array($ratings)) {
            
            $_SESSION['rating_value'] = $rating['rating_value'];
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
}

// SSR call 5: fetch categories
function get_categories() {

    $categories = query("SELECT * FROM categories");
    confirm($categories);

    while($row = fetch_array($categories)) {
        echo "<a href='category.php?cat_id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>";
    };
}

// SSR call 6
function get_products_by_category() {

    $products_by_category = query("SELECT P.*, C.cat_title FROM products AS P LEFT JOIN categories AS C ON P.product_category_id = C.cat_id WHERE P.product_category_id =" . escape_string($_GET['cat_id']) . " ");
    confirm($products_by_category);

    $title_count = 1;

    while($product_by_cat = fetch_array($products_by_category)) {

    $_SESSION['product_info'] = $product_by_cat;

    ob_start();
    include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
    $add_to_cart_button = ob_get_contents();
    ob_end_clean();

    ob_start();
    include(TEMPLATE_FRONT . DS . "rating_total.php");
    $rating_total = ob_get_contents();
    ob_end_clean();

        $cat_title_HTML = "
            <!-- Title -->
                <div class='row'>
                    <div class='col-lg-12 text-left'>
                        <h3>{$product_by_cat['cat_title']}</h3>
                    </div>
                </div>";

        $product_by_cat_HTML = <<<DELIMETER_PROD_BY_CAT

<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
    <a href="item.php?product_id={$product_by_cat['product_id']}"><img src="{$product_by_cat['product_image']}" onerror="this.src='./backup_prod_img.png';" alt="Product"></a>
        <div class="caption-full">
        <a href="item.php?product_id={$product_by_cat['product_id']}"><h3>{$product_by_cat['product_title']}</h3></a>
            <p>{$product_by_cat['product_description_short']}</p>

            {$add_to_cart_button}
    
            {$rating_total}
        </div>
    </div>
</div>

DELIMETER_PROD_BY_CAT;

        if ($title_count === 1) {
            echo $cat_title_HTML;
            $title_count--;
        }

        echo $product_by_cat_HTML;
    }
}

function get_latest_products() {

    $get_latest_products = query("SELECT * FROM products ORDER BY product_id DESC LIMIT 3");
    confirm($get_latest_products);

    while($latest_product = fetch_array($get_latest_products)) {
        $_SESSION['product_info'] = $latest_product;

        ob_start();
        include(TEMPLATE_FRONT . DS . "add_to_cart_button.php");
        $add_to_cart_button = ob_get_contents();
        ob_end_clean();
    
        ob_start();
        include(TEMPLATE_FRONT . DS . "rating_total.php");
        $rating_total = ob_get_contents();
        ob_end_clean();

        $latest_product_HTML = <<<DELIMETER_LATEST_PROD

<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
    <a href="item.php?product_id={$latest_product['product_id']}"><img src="{$latest_product['product_image']}" onerror="this.src='./backup_prod_img.png';" alt="product" ></a>
        <div class="caption-full">
        <a href="item.php?product_id={$latest_product['product_id']}"><h3>{$latest_product['product_title']}</h3></a>
            <p>{$latest_product['product_description_short']}</p>

            {$add_to_cart_button}

        </div>
    </div>
</div>

DELIMETER_LATEST_PROD;

        echo $latest_product_HTML;
    }
}
/* -------------------BACK END FUNCTIONS----------------- */

function login_user() {
    if(isset($_POST['submit'])) {
        $username= escape_string($_POST['username']);
        $password= escape_string($_POST['password']);
        
        $attempt_login = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($attempt_login);

        $login_info = fetch_array($attempt_login);

        if (!$login_info) {
            redirect("login.php");
            set_message("Incorrect Credentials"); 
        } else if ($login_info['is_admin'] == 1 && $username === $login_info['username'] && $password === $login_info['password']) {
            $_SESSION['admin_username'] = $login_info['username'];
            redirect("admin");
        } else {
            redirect("customer_orders.php");
        }
    }
}

function send_message() {
    // if(isset($_POST['submit'])) {
    //     $SeedCommerce_email = "hi5maxf@gmail.com";
    //     $from_name = $_POST['name'];
    //     $sender_email = $_POST['email'];
    //     $subject = $_POST['subject'];
    //     $message = $_POST['message'];

    //     $headers = 'MIME-Version: 1.0' . "\r\n";
    //     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    //     $headers .= 'To: <' . $SeedCommerce_email . '>' . "\r\n";
    //     $headers .= 'From: ' . $from_name . ' <' . $sender_email . '>' . "\r\n";

    //     $result = mail($SeedCommerce_email,$subject,'<html><body>' . $message . '</body></html>', $headers);
        
    //     if(!$result) {
    //         echo "Unable to send due to external error";
    //     } else if (($from_name=="") || ($email=="") || ($message=="")) {
    //         echo "Please fill out all required fields";
    //     } else {
    //         echo "Message successfully sent. Thank you for contacting us!";
    //     }
    // }
}