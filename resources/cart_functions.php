<?php

// Paypal request and response handling
require_once('paypal_config.php');

if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
	// Grab the post data so that we can set up the query string for PayPal.
	// Ideally we'd use a whitelist here to check nothing is being injected into
	// our post data.
	$data = [];
	foreach ($_POST as $key => $value) {
		$data[$key] = stripslashes($value);
	}
	// Set the PayPal account.
	$data['business'] = $paypalConfig['email'];
	// Set the PayPal return addresses.
	$data['return'] = stripslashes($paypalConfig['return_url']);
	$data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
	$data['notify_url'] = stripslashes($paypalConfig['notify_url']);
	// Set the details about the product being purchased, including the amount
	// and currency so that these aren't overridden by the form data.
	$data['item_name'] = $itemName;
	$data['amount'] = $itemAmount;
	$data['currency_code'] = 'USD';
	// Add any custom fields for the query string.
	//$data['custom'] = USERID;
	// Build the query string from the data.
	$queryString = http_build_query($data);
	// Redirect to paypal IPN
	header('location:' . $paypalUrl . '?' . $queryString);
	exit();
} else {
	// Handle the PayPal response.
	// Create a connection to the database.
	$db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);
	// Assign posted variables to local data array.
	$data = [
		'item_name' => $_POST['item_name'],
		'item_number' => $_POST['item_number'],
		'payment_status' => $_POST['payment_status'],
		'payment_amount' => $_POST['mc_gross'],
		'payment_currency' => $_POST['mc_currency'],
		'txn_id' => $_POST['txn_id'],
		'receiver_email' => $_POST['receiver_email'],
		'payer_email' => $_POST['payer_email'],
		'custom' => $_POST['custom'],
	];
	// We need to verify the transaction comes from PayPal and check we've not
	// already processed the transaction before adding the payment to our
	// database.
	if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
		if (addPayment($data) !== false) {
            // Payment successfully added.
            redirect("thank_you.php");
		}
	}
}

// Cart item button handling

if(isset($_GET['remove_from_cart'])) {
    $delete_index = $_GET['remove_from_cart'];
    array_splice($_SESSION['cart'],$delete_index,1);
    redirect("checkout.php");
}

if(isset($_GET['increase_quantity'])) {
    $item_quantity_desired = $_SESSION['cart'][$_GET['item']]['product_quantity'];
    if($item_quantity_desired < $_GET['stock']) {
        $_SESSION['cart'][$_GET['item']]['product_quantity'] += $_GET['increase_quantity'];
        $_SESSION['cart'][$_GET['item']]['product_subtotal'] = $_SESSION['cart'][$_GET['item']]['product_quantity'] * $_SESSION['cart'][$_GET['item']]['product_price'];
        redirect("checkout.php");
    } else {
        set_message("No more in stock!");
        display_message();
        redirect("checkout.php");
    }
}

if(isset($_GET['decrease_quantity'])) {
    $item_quantity_desired = $_SESSION['cart'][$_GET['item']]['product_quantity'];
    if($item_quantity_desired > 1) {
        $_SESSION['cart'][$_GET['item']]['product_quantity'] -= $_GET['decrease_quantity'];
        $_SESSION['cart'][$_GET['item']]['product_subtotal'] = $_SESSION['cart'][$_GET['item']]['product_quantity'] * $_SESSION['cart'][$_GET['item']]['product_price'];
    }
    redirect("checkout.php");
}

// CART TABLE
    function display_cart_table() {

        if($_SESSION['cart'] === []) {
            $_SESSION['cart_total_price'] = 0;
            $_SESSION['cart_item_count'] = 0;
            echo "<h4 class='text-center'>Your cart is empty!</h4>";
        } else {

        $cart_table_beginning = <<<DELIMETER_CTB

<form class="table-responsive" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="sb-k3fgg547468@business.example.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="first_name" value="John">
<input type="hidden" name="last_name" value="Doe">
<input type="hidden" name="address1" value="9 Elm Street">
<input type="hidden" name="address2" value="Apt 5">
<input type="hidden" name="city" value="Berwyn">
<input type="hidden" name="state" value="PA">
<input type="hidden" name="zip" value="19312">
<input type="hidden" name="night_phone_a" value="610">
<input type="hidden" name="night_phone_b" value="555">
<input type="hidden" name="night_phone_c" value="1234">
<input type="hidden" name="email" value="jdoe@zyzzyu.com">


<table class="table table-striped table-condensed">
<thead>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th class='text-center'>Quantity</th>
        <th>In Stock</th>
        <th>Subtotal</th>
    </tr>
</thead>
<tbody>

DELIMETER_CTB;

        echo $cart_table_beginning;

        $_SESSION['cart_item_count'] = 0;
        $_SESSION['cart_total_price'] = 0;
        
        if($_SESSION['cart'] !== []) {

            for($i = 0; $i < count($_SESSION['cart']); $i++) {
                $str_i = "$i";
                $item_id = $_SESSION['cart'][$str_i]['product_id'];
                $item_title = $_SESSION['cart'][$str_i]['product_title'];
                $item_price = $_SESSION['cart'][$str_i]['product_price'];
                $item_quantity = $_SESSION['cart'][$str_i]['product_quantity'];
                $item_subtotal = $_SESSION['cart'][$str_i]['product_subtotal'];
                $stock = $_SESSION['cart'][$str_i]['quantity_left'];

                $cart_items_html = <<<DELIMETER_CART_ITEMS
<tr>
<td>{$item_title}</td>
<td>\${$item_price}</td>
<td>
    <div class='text-center'>{$item_quantity}</div>
    <div class='text-center'>
        <a class='btn btn-warning' href='checkout.php?decrease_quantity=1&item={$i}'><span class='glyphicon glyphicon-minus'></span></a>
        <a class='btn btn-success' href='checkout.php?increase_quantity=1&item={$i}&stock={$stock}'><span class='glyphicon glyphicon-plus'></span></a>
        <a class='btn btn-danger' href='checkout.php?remove_from_cart={$i}'><span class='glyphicon glyphicon-remove'></span></a>
    </div>
</td>
<td>{$stock}</td>
<td>\${$item_subtotal}</td>
</tr>

<input type="hidden" name="item_id" value="{$item_id}">
<input type="hidden" name="item_title" value="{$item_title}">
<input type="hidden" name="item_quanity" value="{$item_quantity}">
<input type="hidden" name="item_price" value="{$item_price}">

DELIMETER_CART_ITEMS;

                $_SESSION['cart_item_count'] = $_SESSION['cart_item_count'] + $item_quantity;
                $_SESSION['cart_total_price'] = $_SESSION['cart_total_price'] + $item_subtotal;
                echo $cart_items_html;
            }
        }

        $cart_table_end = <<<DELIMETER_CTE
    </tbody>
</table>
<input type="hidden" name="amount" value="{$_SESSION['cart_total_price']}" >
<input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
</form>

DELIMETER_CTE;
            
        echo $cart_table_end;
    }
}

// CART TOTALS
function display_cart_summary() {
    $_SESSION['shipping_option'] = "Free Shipping";
    $cart_summary = <<<DELIMETER_CS

<div class="col-xs-4 pull-right ">
    <h2>Cart Totals</h2>

    <table class="table table-bordered" cellspacing="0">
        <tbody>
            <tr class="cart-subtotal">
                <th>Items:</th>
                <td><span class="amount">{$_SESSION['cart_item_count']}</span></td>
            </tr>
            <tr class="shipping">
                <th>Shipping and Handling</th>
                <td>{$_SESSION['shipping_option']}</td>
            </tr>
            <tr class="order-total">
                <th>Total</th>
                <td><strong><span class="amount">\${$_SESSION['cart_total_price']}</span></strong> </td>
            </tr>
        </tbody>
    </table>

</div><!-- CART TOTALS-->

DELIMETER_CS;

    echo $cart_summary;
    
}

?>