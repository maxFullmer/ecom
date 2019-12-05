<div class="row">
    <h1 class="page-header">All Products</h1>

           <?php 
                // Find a way to automatically queue today's date.

                $month_converter_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
                $_SESSION['selected_year'] = date("Y");                

                /* ------ Select Year ------ */
                echo "<select class='month-select'>";
                for ($i_year_dropdown = 2000; $i_year_dropdown <= 2100; $i_year_dropdown++) {
                    echo "<option value='{$i_year_dropdown}'>{$i_year_dropdown}</option>";
                }
                echo "</select>";

                /* ------ Select Month ------ */
                echo "<select class='month-select'>";
                for ($i4 = 0; $i4 < count($month_converter_array); $i4++) {
                    $select_month_name = $month_converter_array[$i4];
                    echo "<option value='{$i4}'>{$select_month_name}</option>";
                }
                echo "</select>";

                /* ------ Carousel ------ */
                $current_month_int = date("m");

                $carousel_start = <<<CAROUSEL_START
<div id="carouselExampleIndicators" class="carousel" data-ride="carousel" data-interval="false">
    <ol class="carousel-indicators">
CAROUSEL_START;

                $carousel_middle = <<<CAROUSEL_MIDDLE

    </ol>
    <div class="carousel-inner">
CAROUSEL_MIDDLE;
    
                $carousel_end = <<<CAROUSEL_END

    </div>
    <a class="left carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
CAROUSEL_END;

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

                echo $carousel_start;

                for ($i5 = 1; $i5 <= 12; $i5++) {
                    if($i5 == $current_month_int) {
                        $carousel_indicator = "<li class='active' data-target='#carouselExampleIndicators' data-slide-to='{$i5}' ></li>";
                    } else {
                        $carousel_indicator = "<li data-target='#carouselExampleIndicators' data-slide-to='{$i5}'</li>";
                    }

                    echo $carousel_indicator;
                }

                echo $carousel_middle;

                for ($i6 = 1; $i6 <= 12; $i6++) {
                    if($i6 == $current_month_int) {
                        $carousel_item_start = "<div class='item active'>";
                    } else {
                        $carousel_item_start = "<div class='item'>";
                    }

                    $display_month_name = $month_converter_array[$i6 - 1];

                    $carousel_item_end = "</div>";
                    // $carousel_item_inner_containter_start = "<div class='carousel-caption d-none d-md-block' >";
                    $carousel_item_inner_containter_start = "<div>";
                    $carousel_item_inner_containter_end = "</div>";

                    echo $carousel_item_start;
                        echo $carousel_item_inner_containter_start;
                            echo "<h2>{$display_month_name}</h2>";
                            echo $product_gross_table_header;
                            get_monthly_product_reports($i6,$_SESSION['selected_year']);
                            echo "</tbody></table>";
                        echo $carousel_item_inner_containter_end;
                    echo $carousel_item_end;
                }

                echo $carousel_end;
            ?>

</div>