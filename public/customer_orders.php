<?php require_once("../resources/config.php"); ?>

<?php 

    if (!$_SESSION['username']) {
        redirect("./index.php");
        } 
    
    if (isset($_GET['logout'])) {
        unset($_SESSION['username']);
        redirect("./index.php");
    }
    
    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }

?>

<!DOCTYPE html>
<html lang="en">

<?php include(TEMPLATE_FRONT . DS . "head.php"); ?>

<body>

    <?php include(TEMPLATE_FRONT . DS . "top_nav.php"); ?>

    <?php 

        var_dump($_SESSION['orders']);
        
    ?>

    <?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>