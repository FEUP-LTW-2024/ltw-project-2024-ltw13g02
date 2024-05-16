<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
  
  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/user.class.php');


  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/productsprint.tpl.php');

  if ($_GET['searchbar'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['searchbar'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['category'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['category'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['type'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['type'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['characteristic'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['characteristic'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['condition'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['condition'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['price-min'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['price-min'])) {
    header('Location: pages/index.php');
  }
  else if ($_GET['price-max'] != NULL && !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['price-max'])) {
    header('Location: pages/index.php');
  }

  $db = getDatabaseConnection();
  drawHeader($session);

  drawPath();

  drawSearchbar();
  if (!isset($_GET['searchbar']) && !isset($_GET['category']) && !isset($_GET['type']) && !isset($_GET['characteristic']) && !isset($_GET['condition']) && !isset($_GET['price-min']) && !isset($_GET['price-max'])) {
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
    drawProductswithFilter();
  }
  drawFooter();
