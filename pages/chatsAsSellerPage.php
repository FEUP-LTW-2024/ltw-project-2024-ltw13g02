<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../templates/chat.tpl.php');

  drawHeader($session);
  drawHamburguerChat($session, 0);
  drawChats($session, 0);
  drawFooter();

