<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  drawHeader($session);
  drawHamburguer($session, 2);
  drawFooter();
  $user = $session->getUser();
?>

<!DOCTYPE html>
<html lang="en-US">
  <body>
    <main>
      <div class="user-info">
        <h2><?php echo $user->getEmail(); ?></h2>
        <h2> my archive </h2>
        <h2><?php echo $user->name(); ?></h2>
      </div>
    </main>
  </body>
</html>

