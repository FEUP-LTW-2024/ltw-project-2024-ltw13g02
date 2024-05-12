<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
  
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/user.class.php');


  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/productsprint.tpl.php');


  $db = getDatabaseConnection();
  drawHeader($session);

  drawPath($_GET['category'], $_GET['type'], $_GET['characteristic']);

  drawSearchbar();

  if ($_GET['category'] == NULL && $_GET['type'] == NULL && $_GET['characteristic'] == NULL) {
    if ($session->isLoggedIn()) 
    {

      $user = $session->getUser();
      $recent_ids = $user->getRecent();
      
      if (sizeof($recent_ids) > 0) {drawRecent($recent_ids); }

    }
    $recommended_ids = getRecommended();
    drawRecommended($recommended_ids);
  }
  else {
    drawProductswithFilter($_GET['category'], $_GET['type'], $_GET['characteristic']);
  }
  drawFooter();
