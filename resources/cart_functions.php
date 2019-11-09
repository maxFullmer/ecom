<?php

    if(isset($_GET['remove_from_cart'])) {
        $delete_index = $_GET['remove_from_cart'];
        array_splice($_SESSION['cart'],$delete_index,1);
        var_dump($_SESSION['cart']);
        // redirect("checkout.php");
    }

    if(isset($_GET['increase_quantity'])) {
        $item_quantity_desired = $_SESSION['cart'][$_GET['item']]['product_quantity'];
        echo $item_quantity_desired;
        if($item_quantity_desired < $_GET['stock']) {
            $_SESSION['cart'][$_GET['item']]['product_quantity'] += $_GET['increase_quantity'];
            $_SESSION['cart'][$_GET['item']]['product_subtotal'] = $_SESSION['cart'][$_GET['item']]['product_quantity'] * $_SESSION['cart'][$_GET['item']]['product_price'];

        } else {
            set_message("No more in stock!");
            display_message();
        }
        
    }

    if(isset($_GET['decrease_quantity'])) {
        $item_quantity_desired = $_SESSION['cart'][$_GET['item']]['product_quantity'];
        if($item_quantity_desired > 1) {
            $_SESSION['cart'][$_GET['item']]['product_quantity'] -= $_GET['decrease_quantity'];
            $_SESSION['cart'][$_GET['item']]['product_subtotal'] = $_SESSION['cart'][$_GET['item']]['product_quantity'] * $_SESSION['cart'][$_GET['item']]['product_price'];
        }
    }

?>