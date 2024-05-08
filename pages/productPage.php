<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  require_once(__DIR__ . '/../templates/product_tmpl.php');

  drawHeader($session);
  drawProductHeader($session, $_GET['product']);
  drawProduct($session, $_GET['product']);
  drawFooter();
