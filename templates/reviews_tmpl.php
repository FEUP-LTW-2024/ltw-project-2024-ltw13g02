<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . "/user_tmpl.php")

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

                        drawStars($stars);
                        ?>
                    </h2>
                </span>
                <span class="rating-score"><?php echo round($session->getStars(), 2); ?></span>
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