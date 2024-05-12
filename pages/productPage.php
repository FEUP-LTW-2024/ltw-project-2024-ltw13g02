<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/product.tpl.php');

  drawHeader($session);
  drawProductHeader($session, $_GET['product']);
  drawProduct($session, $_GET['product']);
  drawFooter();
