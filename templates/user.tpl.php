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

<?php function drawUserProfile(Session $session) { ?>
    <div class="user-info">
        <?php 
        $user = $session->getUser();
        ?>
        <h2><?php drawPhoto($session, $user);?></h2>
        <div class="info">
        <?php
          if($session->isLoggedIn()) {
        ?>
            <h2><?php echo "Name: " . $user->name(); ?></h2>
            <a href="reviewsPage.php"><h2 id="stars" class="stars">
            <?php
              $stars = $user->getStarsFromReviews();
              drawStars($stars);
            ?>
            </h2></a>
            <h2><?php echo "Email: " . $user->getEmail(); ?></h2>
            <h2><?php echo "Phone: " . $user->getPhone(); ?></h2>
            <h2><?php echo "Country: " . $user->getCountry(); ?></h2>
            <h2><?php echo "City: " . $user->getCity(); ?></h2>
            <h2><?php echo "Address: " . $user->getAddress(); ?></h2>
            <h2><?php echo "zipCode: " . $user->getZipCode(); ?></h2>
        <?php
          }
          else {
            ?>
            <h2><?php echo "Guest\n"; ?></h2>
            <h2><?php echo "Login to announce and buy!!"; ?></h2>
            <?php
          }
        ?>
        </div>
    </div>
<?php } ?>

<?php function drawPhoto($session, $user) {
    $user = $session->getUser();
    if($user !== null) { ?>
        <?php $photo = $user->getPhoto(); ?>
        <div class="user-photo-container">
            <?php if ($photo === "Sem FF") { ?>
                <a href="../pages/editingProfile.php" class="user-icon-link">
                    <i class="fa fa-user fa-5x userIconPhoto"></i>
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } else { ?>
                <a href="../pages/editingProfile.php" class="user-photo-link">
                    <img class="userphoto" src="../images/userProfile/<?php echo $photo; ?>" alt="Photo">
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="user-photo-container">
            <a href="../pages/profilePage.php" class="user-icon-link">
            <i class="fa fa-user fa-5x userIconPhoto"></i>
            </a>
        </div>
    <?php }
 } ?>

