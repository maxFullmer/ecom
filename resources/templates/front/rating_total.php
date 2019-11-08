<?php

$get_rating_avg_and_count = query(" SELECT AVG(rating_value), COUNT(rating_value) FROM ratings WHERE rating_product_id =" . escape_string($_SESSION['product_info']['product_id']) . " ");
confirm($get_rating_avg_and_count);
$rating_avg_and_count = fetch_array($get_rating_avg_and_count);

$rating_total_avg = $rating_avg_and_count['0'];
$rating_total_count = $rating_avg_and_count['1'];

$rating_bar = "";
$full_star = "<span class='glyphicon glyphicon-star'></span>";
$empty_star = "<span class='glyphicon glyphicon-star-empty'></span>";
// eventually add half star and update logic below

if (!$rating_total_avg) {
    $stars_from_rating = 0;
} else {
    $stars_from_rating = round($rating_total_avg,0);
}

for($i = 0; $i < $stars_from_rating; $i++) {
    $rating_bar = $rating_bar . $full_star;
};

for($j = 0; $j < 5 - $stars_from_rating; $j++) {
    $rating_bar = $rating_bar . $empty_star;
};

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