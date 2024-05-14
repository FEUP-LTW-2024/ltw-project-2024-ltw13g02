<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/messages.tpl.php');

  if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['chat'])) {
    header('Location: pages/index.php');
  }
  
  drawHeader($session);
  drawChatHeader($session, $_GET['chat']);
  drawMessages($session, $_GET['chat']);
  drawMessagesFooter($session, $_GET['chat']);
