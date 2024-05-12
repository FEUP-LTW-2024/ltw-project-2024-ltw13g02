<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/get_from_db.php');

  require_once(__DIR__ . '/../templates/register.tpl.php');

  drawRegister();
