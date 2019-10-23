<?php require_once("../resources/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>

<body>
    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>
    

    <!-- Page Content -->
<div class="container">

    <?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>

    <div class="col-md-9">

    <!--Row For Image and Short Description-->

    <div class="row">

    <?php get_single_product(); ?>

    </div>

    <hr>

    <!--Row for Tab Panel-->

    <div class="row">

    <div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>
    </ul>

  <!-- Tab panes -->
    <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="home">

    <?php get_product_description_long(); ?>

    </div>

    <div role="tabpanel" class="tab-pane" id="profile">
    
    <?php get_product_reviews(); ?>

    </div>

    </div><!-- -->

    </div><!--Row for Tab Panel-->

    </div>

</div>
    <!-- footer -->
    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
