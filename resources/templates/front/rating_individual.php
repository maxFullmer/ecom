<?php

$stars_from_rating = $_SESSION['rating_value'];

$rating_bar = "";
$full_star = "<span class='glyphicon glyphicon-star'></span>";
$empty_star = "<span class='glyphicon glyphicon-star-empty'></span>";
// eventually add half star and update logic below

for($i = 0; $i < $stars_from_rating; $i++) {
    $rating_bar = $rating_bar . $full_star;
};

for($j = 0; $j < 5 - $stars_from_rating; $j++) {
    $rating_bar = $rating_bar . $empty_star;
};

$rating_lineup_graphic = <<<DELIMETER_RATING_TOTAL

<div class="ratings">
    <p>
        {$rating_bar}
    </p>
</div>

DELIMETER_RATING_TOTAL;

echo $rating_lineup_graphic;
?>