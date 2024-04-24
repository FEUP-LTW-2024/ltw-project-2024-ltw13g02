<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
  drawHamburguer($session);
?>

<!DOCTYPE html>
<html lang="en-US">
  <body>
    <main>
      <div class="user-info">
        <h2><?php echo $session->getEmail(); ?></h2>
        <h2>
          <?php
            $email = $session->getEmail();
            $stars = $session->getStars();
            if ($stars == 0) {
              echo "0 Stars";
            } else {
              for ($i = 0; $i < $stars; $i++) {
                echo '<img class="star" src="star.jpeg" alt="Star">';
              }
            }
            ?>
          </h2>
        <h2><?php echo $session->getFirstName() . " " . $session->getLastName(); ?></h2>
      </div>
    </main>

  </body>
</html>

