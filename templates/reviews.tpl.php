<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . "/user.tpl.php");

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
                        $user = $session->getUser();
                        $stars = $user->getStarsFromReviews();

                        drawStars($stars);
                        ?>
                    </h2>
                </span>
                <span class="rating-score"><?php echo round($stars, 2); ?></span>
            </div>
            <div class="filters">
                <form action="../pages/reviewsPage.php" method="get">
                    <label class="classification" for="classification">Classification:</label>
                    <select id="classific-select" class="classification" name="classification"> <!-- Added name attribute -->
                        <option value="-1"></option>
                        <option value="5"> 5 </option>
                        <option value="4"> 4 </option>
                        <option value="3"> 3 </option>
                        <option value="2"> 2 </option>
                        <option value="1"> 1 </option>
                        <option value="0"> 0 </option>
                    </select>
                    <button id="go" class="button" type="submit">Go</button>
                </form>
            </div>
        </div>
    </body>
    </html>
<?php } ?>

<?php function drawReviews(Session $session, $classification) { 
    $user = $session->getUser();
    $reviews = $user->getReviewsWithUsersFromDB($classification);
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
