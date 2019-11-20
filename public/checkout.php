<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/cart_functions.php"); ?>

<?php
    unset($_SESSION['product_info']);

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if(isset($_POST['add_to_cart_submit'])) {
        $item_already_in_cart = false;


        for ($item_in_cart_index = 0; $item_in_cart_index < count($_SESSION['cart']) ; $item_in_cart_index++) {
            $str_item_in_cart_index = "$item_in_cart_index";

            if($_POST['product_id'] == $_SESSION['cart'][$str_item_in_cart_index]['product_id']) {
                $item_already_in_cart = true;
            }
        }

        if (!$item_already_in_cart) {
            $_SESSION['cart'][] = [
                'product_id' => $_POST['product_id'],
                'product_title' => $_POST['product_title'],
                'product_price' => $_POST['product_price'],
                'product_quantity' => 1,
                'quantity_left' => $_POST['quantity_left'],
                'product_subtotal' => $_POST['product_price'],
            ];
        }        
    }

    unset($_POST['add_to_cart_submit']);
    unset($_POST['product_id']);
    unset($_POST['product_title']);
    unset($_POST['product_price']);
    unset($_POST['quantity_left']);
    
    // if(isset($_GET['paymentfailure'])) {
        
    // }

    if(isset($_POST['cmd'])) {
        $dateTimeAtOrder = new DateTime();
        $_SESSION['orders'][] = [
            'purchase_info' => $_SESSION['cart'],
            'date_ordered' => $dateTimeAtOrder,
            'email' => $_POST['email'],
            'phone' => $_POST['night_phone_a'] . $_POST['night_phone_b'] . $_POST['night_phone_c'],
            'ship_address' => $_POST['address1'] . ", " . $_POST['address2'] . ", " . $_POST['city'] . ", " . $_POST['state'] . ", " . $_POST['zip'],
            'full_name' => $_POST['first_name'] . " " . $_POST['last_name'],
        ];

        log_sales();
       
        var_dump($_SESSION['orders']);
        unset($_POST);
        $_SESSION['cart'] = [];
    }
?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>
    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>

    <div class="container">

        <div class="row">
                <h1>Checkout</h1>

                <?php 

                    if($_SESSION['cart'] === []) {
                        if(!isset($_SESSION['username'])) {
                            $_SESSION['username'] = "Dearest Customer";
                        }
                        $_SESSION['cart_total_price'] = 0;
                        $_SESSION['cart_item_count'] = 0;
                        echo "<h4 class='text-center'>{$_SESSION['username']}, your cart is empty!</h4>";
                    } else {
                        paypal_form_beginning();
                        display_cart_table();
                        display_cart_summary(); 
                        paypal_form_end();
                    }
                ?>
        </div>
        
        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2030</p>
                </div>
            </div>
        </footer>

    </div>

    <script src="js/jquery.js"></script>

    <script src="js/bootstrap.min.js"></script>

    <script src="js/cart_functions.js"></script>

</body>

</html>