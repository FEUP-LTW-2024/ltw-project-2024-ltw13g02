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

  $chat = getChat($_GET['chat']);
  if ($chat->getPossibleBuyer()->id != $session->getUser()->id && $chat->getProduct()->getSeller()->id != $session->getUser()->id) {
    header('Location: ../pages/errorPage.php?error=noAuthorizationAccess');
  }

  if ($_POST['csrf'] == $_SESSION['csrf'] && $_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['message']) && !empty($_POST['message'])) {
    $chat->addMessage($session->getUser()->id, $_POST['message']);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
  }
  
  drawHeader($session);
  drawChatHeader($session, $_GET['chat']);
  drawMessages($session, $_GET['chat']);
  drawMessagesFooter($session, $_GET['chat']);
