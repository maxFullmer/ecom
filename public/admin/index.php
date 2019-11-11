<?php require_once("../../resources/config.php"); ?>

<?php 

    if (!$_SESSION['admin_username']) {
        redirect("../../public");
        } 
    
    if (isset($_GET['logout'])) {
        unset($_SESSION['admin_username']);
        redirect("../../public");
    }
        
    ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_BACK . DS . "head_admin.php"); ?>

<body>

    <div id="wrapper">

        <?php include(TEMPLATE_BACK . DS . "nav_admin.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Dashboard <small>Statistics Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            <?php 
                if($_SERVER['REQUEST_URI'] == "/ecom/public/admin/" || $_SERVER['REQUEST_URI'] == "/ecom/public/admin/index.php") {
                    include(TEMPLATE_BACK . DS . "index_content_admin.php");
                }
                if(isset($_GET['orders'])) {
                    include(TEMPLATE_BACK . DS . "orders_content_admin.php");
                }
                if(isset($_GET['add_product'])) {
                    include(TEMPLATE_BACK . DS . "add_product_content_admin.php");
                }
                if(isset($_GET['products'])) {
                    include(TEMPLATE_BACK . DS . "products_content_admin.php");
                }
                if(isset($_GET['categories'])) {
                    include(TEMPLATE_BACK . DS . "categories_content_admin.php");
                } 
            ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>