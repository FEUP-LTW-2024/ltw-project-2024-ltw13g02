<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawStars($stars) { 
    $filledStars = floor($stars);
    if($stars - $filledStars > 0.5)  $filledStars++;
    else if ($stars - $filledStars <= 0.5 && $stars - $filledStars > 0) $hasHalfStar = true;

    for ($i = 1; $i <= 5; $i++) {
        $filled = $i <= $filledStars;
        if ($filled) echo '<i class="fa fa-star"></i>';
        else if ($hasHalfStar) {
        echo '<i class="fa fa-star-half-o"></i>';
        $hasHalfStar = false;
        }
        else echo '<i class="fa fa-star-o"></i>';
    }
} ?>