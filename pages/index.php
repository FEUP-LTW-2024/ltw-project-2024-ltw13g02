<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
  
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/user.class.php');


  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/productsprint.tpl.php');
  require_once(__DIR__ . '/../vendor/autoload.php');



  $db = getDatabaseConnection();
  drawHeader($session);

  drawPath();
  drawSearchbar();

  if ($session->isLoggedIn()) {
    $recents = $session->getUser()->getRecent();
    if ($recents != null) {
      drawRecent($recents);
    }
  }

  $recommended = getRecommended();
  drawRecommended($recommended);
  drawFooter();
