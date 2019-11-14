<?php

// Cart item button request handling

if(isset($_GET['remove_from_cart'])) {
    unset($_SESSION['cart']['']);
    $delete_index = $_GET['remove_from_cart'];
    array_splice($_SESSION['cart'],$delete_index,1);
    redirect("checkout.php");
}

if(isset($_GET['change_quantity'])) {
    $item_selected = $_GET['item'];
    $item_quantity_desired = intval($_GET['change_quantity']);
    var_dump($item_selected);
    if($item_quantity_desired > 0 && $item_quantity_desired <= intval($_GET['stock'])) {
        $_SESSION['cart'][$item_selected]['product_quantity'] = $_GET['change_quantity'];
        $_SESSION['cart'][$item_selected]['product_subtotal'] = $_SESSION['cart'][$_GET['item']]['product_quantity'] * $_SESSION['cart'][$_GET['item']]['product_price'];
        redirect("checkout.php");
    } else {
        redirect("checkout.php");
    }
}

// Views + Form Handling

function paypal_form_beginning() {
    $cart_form_beginning = <<<DELIMETER_CFB

<form class="table-responsive" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="upload" value="1" >
    <input type="hidden" name="business" value="sb-k3fgg547468@business.example.com" >
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="currency_code" value="USD">

DELIMETER_CFB;
    echo $cart_form_beginning;
}

// CART TABLE
function display_cart_table() {   
        $cart_table_beginning = <<<DELIMETER_CTB

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
                $cart_index = "$i";
                $paypal_index = $i + 1;
                $item_id = $_SESSION['cart'][$cart_index]['product_id'];
                $item_title = $_SESSION['cart'][$cart_index]['product_title'];
                $item_price = $_SESSION['cart'][$cart_index]['product_price'];
                $item_quantity = $_SESSION['cart'][$cart_index]['product_quantity'];
                $item_subtotal = $_SESSION['cart'][$cart_index]['product_subtotal'];
                $stock = $_SESSION['cart'][$cart_index]['quantity_left'];

                $cart_items_html = <<<DELIMETER_CART_ITEMS
<tr>
<td>{$item_title}</td>
<td>\${$item_price}</td>
<td>
    <div class="text-center">{$item_quantity}</div>
    <div class="text-center">
        <input id="{$cart_index}" type="number" placeholder="Update" min="1" max="{$stock}" >
        <div class="btn btn-primary" onclick="update_quantity(this.previousElementSibling)" ><span class="glyphicon glyphicon-refresh"></span></div>
        <a class="btn btn-danger" href="checkout.php?remove_from_cart={$cart_index}"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
</td>
<td>{$stock}</td>
<td>\${$item_subtotal}</td>
</tr>

<input type="hidden" name="amount_{$paypal_index}" value="{$item_price}" >
<input type="hidden" name="item_name_{$paypal_index}" value="{$item_title}" >
<input type="hidden" name="item_number_{$paypal_index}" value="{$item_id}" >
<input type="hidden" name="quantity_{$paypal_index}" value="{$item_quantity}" >

DELIMETER_CART_ITEMS;

                $_SESSION['cart_item_count'] = $_SESSION['cart_item_count'] + $item_quantity;
                $_SESSION['cart_total_price'] = $_SESSION['cart_total_price'] + $item_subtotal;
                echo $cart_items_html;
            }
        }

        $cart_table_end = "</tbody></table>";
        echo $cart_table_end;
}

// CART TOTAL
function display_cart_summary() {
    $_SESSION['shipping_option'] = "Free Shipping";
    $cart_summary = <<<DELIMETER_CS
<hr>
<div class="col-4">
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

function paypal_form_end() {
    $paypal_form_end = <<<DELIMETER_PFE
<hr>
    <h2>Shipping Information</h2>
    <div>
        <label for="first_name">First Name: </label>
        <input type="text" name="first_name" value="John">
    </div>
    <div>
        <label for="last_name">Last Name: </label>
        <input type="text" name="last_name" value="Doe">
    </div>
    <div>
        <label for="address1">Address 1: </label>
        <input type="text" name="address1" value="9 Elm Street">
    </div>
    <div>
        <label for="address2">Address 2: </label>
        <input type="text" name="address2" value="Apt 5">
    </div>
    <div>
        <label for="city">City: </label>
        <input type="text" name="city" value="Berwyn">
    </div>
    <div>
        <label for="state">State: </label>
        <input type="text" name="state" value="PA">
    </div>
    <div>
        <label for="zip">Zip Code: </label>
        <input type="text" name="zip" value="19312">
    </div>
    <div>
        <label for="night_phone_a">First 3 of Phone Number: </label>
        <input type="text" name="night_phone_a" value="408">
    </div>
    <div>
        <label for="night_phone_b">Middle 3 of Phone Number: </label>
        <input type="text" name="night_phone_b" value="838">
    </div>
    <div>
        <label for="night_phone_c">Last 4 of Phone Number: </label>
        <input type="text" name="night_phone_c" value="5807">
    </div>
    <div>
        <label for="email">PayPal Email: </label>
        <input type="email" name="email" value="sb-rky1f546415@personal.example.com">
    </div>

    <hr>
    <div class="text-center">
        <p>If you would like to view orders within past 90 days, <a href="#">Create An Account</a> first. Otherwise, go ahead and ... </p>
        <input type="image" name="submit" border="0"
            src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png" 
            alt="PayPal Buy Now" 
        />
        
    </div>
</form>

DELIMETER_PFE;

    echo $paypal_form_end;
}

?>