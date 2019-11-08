<?php 

    if(isset($_GET['add'])) {

        $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']). " ");
        confirm($query);

        while($row = fetch_array($query)) {

            if($row['quantity_left'] > $_SESSION['product_' . $_GET['add']]) {
                $_SESSION['product_' . $_get['add']] += 1;
                redirect("checkout.php");
            } else {
                set_message("No more in stock " . $row['quantity_left']);
                redirect("checkout.php");
            }
        }
        
        
    }

    if (isset($_GET['decrement'])) {
        $_SESSION['product_' . $_GET['decrement']]--;

        if($_SESSION['product_' . $_GET['decrement']] < 1) {
            redirect("checkout.php");
        } else {
            redirect("checkout.php");
        }
    }

    if (isset($_GET['remove_from_cart'])) {
        $_SESSION['product_' . $_GET['remove_from_cart']] = '0';
        redirect("checkout.php");
    }

?>