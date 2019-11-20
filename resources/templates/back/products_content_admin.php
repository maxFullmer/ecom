<div class="row">
    <h1 class="page-header">All Products</h1>

           <?php 
                // replace $i3 < 4 with $i3 < length of $product_id_array
                $month_converter_array = ["January","February","March","April","May","June","July","August","September","October","November","December"];
   
                for ($month_int = 1; $month_int <= 12; $month_int++) {
                    $display_month = $month_converter_array[$month_int - 1];

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
                }
            ?>

</div>