<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/edit_tmpl.php');


  drawHeader($session);
  drawHamburguer($session, 0);
  drawConfirmLogIn($session);
  drawFooter();
?>