<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="./index.php">SeedCommerce Admin</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['admin_username']; ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                
                <li class="divider"></li>
                <li>
                    <?php echo "<a href='./index.php?logout'><i class='fa fa-fw fa-power-off'></i>Log Out</a>"; ?>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="active">
                <a href="index.php?orders"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="index.php?products"><i class="fa fa-fw fa-bar-chart-o"></i> View Products</a>
            </li>
            <li>
                <a href="index.php?add_product"><i class="fa fa-fw fa-table"></i> Add Product</a>
            </li>
            <li>
                <a href="index.php?categories"><i class="fa fa-fw fa-desktop"></i> Categories</a>
            </li>
            <li>
                <a href="index.php?users"><i class="fa fa-fw fa-wrench"></i>Users</a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>