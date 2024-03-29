<?php require_once("../resources/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

            <div class="col-md-9">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div class="text-center">FEATURED SEASONAL SELECTIONS</div>
                        <?php include(TEMPLATE_FRONT . DS . "slider.php"); ?>
                    </div>

                </div>

                <div class="row">
                <div class="col-lg-12">
                    <h3>Latest Products</h3>
                        <?php get_latest_products(); ?>
                    </div>
                </div><!-- row ends here -->

            </div>

        </div>

    </div>

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>