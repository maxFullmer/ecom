<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/cart_functions.php"); ?>

<?php
    unset($_SESSION['product_info']);

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if(isset($_POST['add_to_cart_submit'])) {
        $_SESSION['cart'][] = [
            'product_id' => $_POST['product_id'],
            'product_title' => $_POST['product_title'],
            'product_price' => $_POST['product_price'],
            'product_quantity' => 1,
            'quantity_left' => $_POST['quantity_left'],
            'product_subtotal' => $_POST['product_price'],
        ];
    }

    unset($_POST['add_to_cart_submit']);
    unset($_POST['product_id']);
    unset($_POST['product_title']);
    unset($_POST['product_price']);
    unset($_POST['quantity_left']);
    // session_unset();
?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <!-- cart.php -->

      <!-- Navigation -->
        <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>

    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">

        <h1>Checkout</h1>

        <?php display_cart_table(); ?>
            
        <?php display_cart_summary(); ?>

 </div><!--Main Content-->


           <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2030</p>
                </div>
            </div>
        </footer>


    </div>
    <!-- /.container -->

     <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/cart_functions.js"></script>

</body>

</html>
