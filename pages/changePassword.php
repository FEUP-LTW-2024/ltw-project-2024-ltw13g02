<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  

  require_once(__DIR__ . '/../templates/edit.tpl.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newPassword = $_POST['newPassword'];
    
    header("Location: /../actions/changePasswordAction.php?password=$newPassword");
    exit();
}

  drawHeader($session);
  drawHamburguer($session, 0);
  drawChangePassword($session);
  drawFooter();
?>