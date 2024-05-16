<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/get_from_db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../templates/reviews.tpl.php');

  drawHeader($session);
  drawHamburguer($session, 0);
  drawFilterBar($session);
  if (!isset($_GET['classification'])) drawReviews($session, -1);
  else drawReviews($session, $_GET['classification']);
  drawFooter();
