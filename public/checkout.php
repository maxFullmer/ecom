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

      <form action="">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if($_SESSION['cart'] !== []) {
                        var_dump($_SESSION['cart']);
                        for($i = 0; $i < count($_SESSION['cart']); $i++) {
                            $str_i = "$i";
                            $item_title = $_SESSION['cart'][$str_i]['product_title'];
                            $item_price = $_SESSION['cart'][$str_i]['product_price'];
                            $item_quantity = $_SESSION['cart'][$str_i]['product_quantity'];
                            $item_subtotal = $_SESSION['cart'][$str_i]['product_subtotal'];
                            $stock = $_SESSION['cart'][$str_i]['quantity_left'];

                            $cart_items_html = <<<DELIMETER_CART_ITEMS
<tr class="removable">
    <td>{$item_title}</td>
    <td>\${$item_price}</td>
    <td>{$item_quantity}</td>
    <td>\${$item_subtotal}</td>
    <td ="maxstock"><a href='checkout.php?increase_quantity=1&item={$i}&stock={$stock}'>+ Increase Quantity</a></td>
    <td><a href='checkout.php?decrease_quantity=1&item={$i}'>- Decrease Quantity</a></td>
    <td><a href='checkout.php?remove_from_cart={$i}'>Remove Item</a></td>
</tr>

DELIMETER_CART_ITEMS;

                            echo $cart_items_html;
                        }
                // session_unset();
                    }
        ?>
            </tbody>
        </table>
    </form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount">4</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">$3444</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


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
