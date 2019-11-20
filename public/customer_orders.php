<?php require_once("../resources/config.php"); ?>

<?php 

    if (!$_SESSION['username']) {
        redirect("./index.php");
        } 
    
    if (isset($_GET['logout'])) {
        unset($_SESSION['username']);
        redirect("./index.php");
    }
    
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>

    <?php

    for($orderCount = 0; $orderCount < count($_SESSION['orders']); $orderCount++) {
                $order_index = "$orderCount";
                
    $order_table_head = <<<DELIMETER_OTH

<table class="table table-striped table-condensed">
<thead>
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Date Ordered</th>
    </tr>
</thead>
<tbody>

DELIMETER_OTH;

        echo $order_table_head;

        for($order_item_count = 0; $order_item_count < count($_SESSION['orders'][$order_index]['purchase_info']); $order_item_count++) {
            $order_item_index = "$order_item_count";
            $item_title_order = $_SESSION['orders'][$order_index]['purchase_info'][$order_item_index]['product_title'];        
            $item_price_order = $_SESSION['orders'][$order_index]['purchase_info'][$order_item_index]['product_price'];
            $item_subtotal_order = $_SESSION['orders'][$order_index]['purchase_info'][$order_item_index]['product_subtotal'];
            $item_quantity_order = $_SESSION['orders'][$order_index]['purchase_info'][$order_item_index]['product_quantity'];
            $date_order = $_SESSION['orders'][$order_index]['date_ordered']->format('Y-m-d H:i:s');

            $order_table_body = <<<DELIMETER_OTB
<tr>
<td>{$item_title_order}</td>
<td>\${$item_price_order}</td>
<td>{$item_quantity_order}</td>
<td>\${$item_subtotal_order}</td>
<td>{$date_order}</td>
</tr>
DELIMETER_OTB;

            echo $order_table_body;
        }
        $order_item_count = 0;

        $order_table_end = "</tbody></table>";
        echo $order_table_end;
    }
        
    ?>

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>