<div class="row">
    <h1 class="page-header">All Products</h1>

           <?php 
                /* 
                    NEW PLAN: 
                    1) incorporate js slider for month and year
                    2) have the active class for carousel slide be the current month
                    3) 
                */
                $month_converter_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];

                /* ------ Select ------ */
                echo "<select class='month-select'>";
                for ($i4 = 0; $i4 < count($month_converter_array); $i4++) {
                    $select_month_name = $month_converter_array[$i4];
                    echo "<option value='{$i4}'>{$select_month_name}</option>";
                }
                echo "</select>";

                /* ------ Carousel ------ */
                $current_month_int = date("m");
                $display_month_int = $current_month_int;
                $display_month_name = $month_converter_array[$display_month_int - 1];

                $carousel_start = <<<CAROUSEL_START
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
CAROUSEL_START;

                $carousel_middle = <<<CAROUSEL_MIDDLE

    </ol>
    <div class="carousel-inner">
CAROUSEL_MIDDLE;
    
                $carousel_end = <<<CAROUSEL_END

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
                        $carousel_item_start = "<div class='carousel-item active'>";
                    } else {
                        $carousel_item_start = "<div class='carousel-item'>";
                    }
                    $carousel_item_end = "</div>";
                    $carousel_item_inner_containter_start = "<div class='carousel-caption d-none d-md-block' >";
                    $carousel_item_inner_containter_end = "</div>";

                    echo $carousel_item_start;
                        echo $carousel_item_inner_containter_start;
                            echo "<h2>{$display_month_name}</h2>";
                            echo $product_gross_table_header;
                            get_monthly_product_reports($i6);
                            echo "</tbody></table>";
                        echo $carousel_item_inner_containter_end;
                    echo $carousel_item_end;
                }

                echo $carousel_end;

                    
                    // echo "<h2>{$display_month_name}</h2>";
                    // echo $product_gross_table_header;
                    // get_monthly_product_reports($display_month_int);
                    // echo "</tbody></table>";
//                 // }
            ?>

</div>