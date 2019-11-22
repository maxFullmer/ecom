<div class="row">
    <h1 class="page-header">All Products</h1>

           <?php 
                /* 
                    NEW PLAN: 
                    1) incorporate js slider for month and year
                    2) have the active class for carousel slide be the current month
                    3) 
                */


                // replace $i3 < 4 with $i3 < length of $product_id_array
                $month_converter_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];

                $carousel_months = <<<DELIMETER_CM
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
<ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="6"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="7"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="8"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="9"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="10"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="11"></li>
</ol>
<div class="carousel-inner">
    <div class="carousel-item active">
    <img class="d-block w-100" src="..." alt="First slide">
    </div>
    <div class="carousel-item">
    <img class="d-block w-100" src="..." alt="Second slide">
    </div>
    <div class="carousel-item">
    <img class="d-block w-100" src="..." alt="Third slide">
    </div>
</div>
<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
</a>
<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
</a>
</div>
DELIMETER_CM;
                echo $carousel_months;
                // for ($month_int = 1; $month_int <= 12; $month_int++) {
                    $display_month = $month_converter_array[$month_int - 1];
                    // $display_month_num = date("m");
                    // $display_month = $month_converter_array[$display_month_num - 1];

                    $product_gross_table_header = <<<DELIMETER_PGTH
        
<table class='table table-hover'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Gross</th>
        </tr>
    </thead>
    <tbody>

DELIMETER_PGTH;

                    echo "<h2>{$display_month}</h2>";
                    echo $product_gross_table_header;
                    get_monthly_product_reports($month_int);
                    echo "</tbody></table>";
                // }
            ?>

</div>