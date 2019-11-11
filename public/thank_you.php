<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/cart_functions.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <?php

        if(isset($_GET['tx'])) {
            $amount = $_GET['amt'];
            $currency = $_GET['cc'];
            $transaction = $_GET['tx'];
            $status = $_GET['st'];

            $update_orders = query("INSERT INTO orders (order_amount, order_transaction,
                order_status, order_currency) VALUES ('{$amount}', '{$transaction}','{$status}',
                '{$currency}')");
            confirm($update_orders);

            $update_product_stock = query("UPDATE products SET quantity_left")
        } else {
            redirect("checkout.php?paymentfailed=badpayment");
        }

    ?>

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/cart_functions.js"></script>

</body>

</html>