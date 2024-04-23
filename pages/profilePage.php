<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
?>

<!DOCTYPE html>
<html lang="en-US">
<body>
    <main>
      <h2> NAME: </h2>
      <h2 id="username"><?php echo $session->getEmail(); ?></h2>
      <a href="login.php"><h2 id="goToLogin">Login</h2></a>
    </main>
</body>