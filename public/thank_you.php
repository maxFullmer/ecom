<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/paypal_config.php"); ?>

<?php 
    var_dump($_POST);
    // if(isset($_GET['tx'])) {
    //     var_dump($_GET);
    //     $amount = $_GET['amt'];
    //     $currency = $_GET['cc'];
    //     $transaction = $_GET['tx'];
    //     $status = $_GET['st'];

    //     $update_orders = query("INSERT INTO orders (order_amount, order_transaction,
    //         order_status, order_currency) VALUES ('{$amount}', '{$transaction}','{$status}',
    //         '{$currency}')");
    //     confirm($update_orders);

    //     // $update_product_stock = query("UPDATE products SET quantity_left");
    // } else {
    //     // redirect("checkout.php?paymentfailed=badpayment");
    //     redirect("./index.php");
    // }


    // THE REAL PLAN:

    /* 
    If (payment failed):
        1) Don't touch the $_SESSION['cart']
        2) Tell the customer what happened and where to go/what to do
            a) if paypal error -> that will be handled by them
            b) if client side error -> ask them to check connection or wait a few moments and try again
        3) Don't make db calls

    else(if) (payment verified): 
        1) store all order info based off what is in cart
        2) send all that to orders table for logging
        3) send only quantity_purchased for each item to
            a) products table to update stock left
            b) reports table to update how much stock has been sold for a product
        4) unset($_SESSION['cart']);
    
    */
?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <?php

        // if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
        //     // Grab the post data so that we can set up the query string for PayPal.
        //     // Ideally we'd use a whitelist here to check nothing is being injected into
        //     // our post data.
        //     $data = [];
        //     foreach ($_POST as $key => $value) {
        //         $data[$key] = stripslashes($value);
        //     }
        //     // Set the PayPal account.
        //     $data['business'] = $paypalConfig['email'];
        //     // Set the PayPal return addresses.
        //     $data['return'] = stripslashes($paypalConfig['return_url']);
        //     $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
        //     $data['notify_url'] = stripslashes($paypalConfig['notify_url']);
        //     // Set the details about the product being purchased, including the amount
        //     // and currency so that these aren't overridden by the form data.
        //     $data['item_name'] = $itemName;
        //     $data['amount'] = $itemAmount;
        //     $data['currency_code'] = 'USD';
        //     // Add any custom fields for the query string.
        //     //$data['custom'] = USERID;
        //     // Build the query string from the data.
        //     $queryString = http_build_query($data);
        //     // Redirect to paypal IPN
        //     header('location:' . $paypalUrl . '?' . $queryString);
        //     exit();
        // } else {
        //     // Handle the PayPal response.
        //     // Create a connection to the database.
        //     $db = new mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['name']);
        //     // Assign posted variables to local data array.
        //     $data = [
        //         'item_name' => $_POST['item_name'],
        //         'item_number' => $_POST['item_number'],
        //         'payment_status' => $_POST['payment_status'],
        //         'payment_amount' => $_POST['mc_gross'],
        //         'payment_currency' => $_POST['mc_currency'],
        //         'txn_id' => $_POST['txn_id'],
        //         'receiver_email' => $_POST['receiver_email'],
        //         'payer_email' => $_POST['payer_email'],
        //         'custom' => $_POST['custom'],
        //     ];
        //     // We need to verify the transaction comes from PayPal and check we've not
        //     // already processed the transaction before adding the payment to our
        //     // database.
        //     if (verifyTransaction($_POST) && checkTxnid($data['txn_id'])) {
        //         if (addPayment($data) !== false) {
        //             // Payment successfully added, so define order array and push into $_SESSION['user_orders']

        //             // and also push order into database so admin can view

        //             // finally tell the buyer that order was successful
        //             $payment_success = "<span>Your payment was sucessfully processed. <a href='./login.php'>Log In</a>to view your orders within the last 30 days.<span>";
        //             echo $payment_success;
        //         }
        //     }
        // }

        // OR 

        // if(isset($_GET['tx'])) {
        //     $amount = $_GET['amt'];
        //     $currency = $_GET['cc'];
        //     $transaction = $_GET['tx'];
        //     $status = $_GET['st'];

        //     $update_orders = query("INSERT INTO orders (order_amount, order_transaction,
        //         order_status, order_currency) VALUES ('{$amount}', '{$transaction}','{$status}',
        //         '{$currency}')");
        //     confirm($update_orders);

        //     $update_product_stock = query("UPDATE products SET quantity_left")
        // } else {
        //     redirect("checkout.php?paymentfailed=badpayment");
        // }

    ?>

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/cart_functions.js"></script>

</body>

</html>