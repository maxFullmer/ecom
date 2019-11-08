<?php

$product_title = $_SESSION['product_info']['product_title'];
$product_price = $_SESSION['product_info']['product_price'];
$quantity_left = $_SESSION['product_info']['quantity_left'];

echo "<form action='checkout.php' method='post'>
        <div class='form-group'>
            <input type='hidden' name='product_title' value='{$product_title}' >
            <input type='hidden' name='product_price' value='{$product_price}' >
            <input type='hidden' name='quantity_left' value='{$quantity_left}' >
            <input type='submit' class='btn btn-primary' name='add_to_cart_submit' value='ADD TO CART'>
        </div>
</form>";

?>