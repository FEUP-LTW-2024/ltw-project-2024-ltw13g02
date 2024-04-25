<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
?>

<?php function drawFilterBar(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    </head>
    <body>
        <div class="review-container">
            <div class="average-rating">
                <span class="stars">
                    <h2 id="stars">
                        <?php
                        $stars = $session->getStars();

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
                        ?>
                    </h2>
                </span>
                <span class="rating-score"><?php echo $session->getStars(); ?></span>
            </div>
            <div class="filters">
                <label for="classification">Classification:</label>
                <select id="classification">
                    <option value="highest">Highest first</option>
                    <option value="lowest">Lowest first</option>
                </select>
                <label for="order">Order:</label>
                <select id="order">
                    <option value="newest">Newest first</option>
                    <option value="oldest">Oldest first</option>
                </select>
            </div>
        </div>
    </body>
    </html>
<?php } ?>

<?php function drawReviews(Session $session) { 
    $reviews = getReviewsFromDB($session->getId());
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    </head>
    <body>
        <div class="review-list">
        <?php
            foreach ($reviews as $row) {
                ?>
                <div class="review">
                    <p><strong>Stars:</strong> <?php echo $row['stars']; ?></p>
                    <p><strong>Review:</strong> <?php echo $row['reviewsDescription']; ?></p>
                </div>
                <?php
            }
            ?>
        </div>
    </body>
    </html>
<?php } ?>