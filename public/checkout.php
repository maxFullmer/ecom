<?php require_once("../resources/config.php"); ?>
<?php require_once("../resources/cart_functions.php"); ?>

<?php
    unset($_SESSION['products_info_array']);
    unset($_SESSION['single_product_info']);

    if(isset($_POST['add_to_cart_submit']) && isset($_POST['product_title']) && isset($_POST['product_price'])) {
        $_SESSION['cart'][] = [
            'product_title' => $_POST['product_title'],
            'product_price' => $_POST['product_price'],
        ];
    }

    unset($_POST['add_to_cart_submit']);
    unset($_POST['product_title']);
    unset($_POST['product_price']);

    var_dump($_SESSION['cart']);
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
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <tr>
                <td>apple</td>
                <td>$23</td>
                <td>3</td>
                <td>2</td>
                <td><a href="cart.php?decrement=1">-</a></td>
                <td><a href="cart.php?remove_from_cart=1">Remove From Cart</a></td>
              
            </tr>
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

</body>

</html>
