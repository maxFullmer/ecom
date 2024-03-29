<?php require_once("../resources/config.php"); ?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "/head.php"); ?>

<body>

    <!-- Navigation -->
    <?php include(TEMPLATE_FRONT . DS . "/top_nav.php"); ?>

    <!-- Page Content -->
    <div class="container">

      <header>
            <h1 class="text-center">Login</h1>
            <h3 class="text-center bg-warning"><?php display_message(); ?></h3>
        <div class="col-sm-4 col-sm-offset-5">         
            <form class="" action="" method="post" enctype="multipart/form-data">
            <?php login_user(); ?>
            <div class="form-group"><label for="">
                    Username<input type="text" name="username" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="password" name="password" class="form-control"></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
            </form>
        </div>  


    </header>


        </div>

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "/footer.php"); ?>

    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
