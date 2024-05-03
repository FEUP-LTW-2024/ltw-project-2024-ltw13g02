<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  $db = getDatabaseConnection();

  drawHeader($session);
  drawHamburguer($session, 0);
  drawFooter();
?>

<!DOCTYPE html>
<html lang="en-US">
<body>
<main class="center-text">
    <div class="user-info">
        <?php $email = $session->getEmail(); ?>
        <div class="info">
        <?php
          if($email != null) {
        ?>
            <h2><?php echo "First Name: " . $session->getFirstName(); ?></h2>
            <h2><?php echo "Last Name: " . $session->getLastName(); ?></h2>
            <h2><?php echo "Email: " . $email = $session->getEmail(); ?></h2>
            <h2><?php echo "Phone: " . $session->getPhone(); ?></h2>
            <h2><?php echo "Country: " . $session->getCountry(); ?></h2>
            <h2><?php echo "City: " . $session->getCity(); ?></h2>
            <h2><?php echo "Address: " . $session->getAddress(); ?></h2>
            <h2><?php echo "zipCode: " . $session->getZipCode(); ?></h2>
        <?php
          }
        ?>
        </div>
    </div>
  </body>
</html>

