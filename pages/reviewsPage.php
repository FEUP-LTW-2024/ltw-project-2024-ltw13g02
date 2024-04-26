<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../database/get_from_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  require_once(__DIR__ . '/../templates/reviews_tmpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
  drawHamburguer($session, 0);
  drawFilterBar($session);
  drawReviews($session);
?>