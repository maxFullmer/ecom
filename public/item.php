<?php require_once("../resources/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<body>
    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>
    

    <!-- Page Content -->
<div class="container">

       <!-- Side Navigation -->

    <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

    <!-- moved to get_single_product() -->

    <?php get_single_product(); ?>

</div>
    <!-- footer -->
    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
