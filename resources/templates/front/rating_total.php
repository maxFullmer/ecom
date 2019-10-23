<?php

$get_rating_total_sum = query(" SELECT SUM(rating_value) FROM ratings WHERE rating_product_id =" . escape_string($_SESSION['current_product_id']) . " ");
confirm($get_rating_total_sum);
$rating_total_sum = fetch_array($get_rating_total_sum)[0];

$get_rating_total_count = query(" SELECT COUNT(rating_value) FROM ratings WHERE rating_product_id =" . escape_string($_SESSION['current_product_id']) . " ");
confirm($get_rating_total_count);
$rating_total_count = fetch_array($get_rating_total_count)[0];

$rating_bar = "";
$full_star = "<span class='glyphicon glyphicon-star'></span>";
$empty_star = "<span class='glyphicon glyphicon-star-empty'></span>";
// eventually add half star and update logic below

if ($rating_total_count == 0) {
    for($h = 0; $h < 5; $h++) {
        $rating_bar = $rating_bar . $empty_star;
    };
} else {
    $rating_total_avg = $rating_total_sum / $rating_total_count;

    $stars_from_rating = round($rating_total_avg,0);
    
    for($i = 0; $i < $stars_from_rating; $i++) {
        $rating_bar = $rating_bar . $full_star;
    };
    
    for($j = 0; $j < 5 - $stars_from_rating; $j++) {
        $rating_bar = $rating_bar . $empty_star;
    };
}

$rating_total_graphic = <<<DELIMETER_RATING_TOTAL

<div class="ratings">
    <p class="pull-right">{$rating_total_count} reviews</p>
    <p>
        {$rating_bar}
    </p>
</div>

DELIMETER_RATING_TOTAL;

echo $rating_total_graphic;
?>