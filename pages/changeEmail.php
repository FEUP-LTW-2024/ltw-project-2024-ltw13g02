<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/edit_tmpl.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newEmail = $_POST['email'];
    
    header("Location: /../actions/changeEmailAction.php?email=$newEmail");
    exit();
}

  drawHeader($session);
  drawHamburguer($session, 0);
  drawChangeEmail($session);
  drawFooter();
?>