<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . "/user_tmpl.php");

?>

<?php function drawFilterBar(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    </head>
    <body>
        <div class="filterBar-container">
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
    $reviews = getReviewsWithUsersFromDB($session->getId());
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
                    <h2 class="review-user"><?php echo $row['firstName'] . " " . $row['lastName']; ?></h2>
                    <h2 class="created-at"><?php echo $row['created_at']; ?></h2>
                    <h2 id="stars"><?php drawStars($row['stars']);?></h2>
                    <h2 class="review-description"><?php echo $row['reviewsDescription']; ?></h2>
                </div>
                <?php
            }
            ?>
        </div>
    </body>
    </html>
<?php } ?>