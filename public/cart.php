<?php require_once("../resources/config.php"); ?>

<?php 

    if(isset($_GET['add'])) {

        $query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['add']). " ");
        confirm($query);

        while($row = fetch_array($query)) {

            if($row['quantity_left'] != $_SESSION['product_' . $_GET['add']]) {
                $_SESSION['product_' . $_get['add']] += 1;
            } else {
                set_message("No more in stock " . $row['quantity_left'])
            }
        }
        
        
    }

?>