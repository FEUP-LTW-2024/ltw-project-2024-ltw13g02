<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../database/get_from_db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');

  require_once(__DIR__ . '/../templates/reviews.tpl.php');


  if (!isset($_GET['user'])) {
    header('Location: ../index.php');
  }

  if (!preg_match("/^[0-9a-zA-Z]+$/", $_GET['user'])) {
    header('Location: ../index.php');
  }
  $user = getUserbyId($_GET['user']);
  if (!isset($user)) {
    header('Location: ../index.php');
  }
  ?> <script src="../javascript/reviews.js" defer></script> <?php
  $currentUser = $session->getUser();
  drawHeader($session);
  if ($currentUser->id === $user->id) { //Same user
    drawHamburguer($session, 0);
    drawFilterBar($user);
  }else if (isset($currentUser)){       //Diferent users
    drawFilterBar($user); 
    drawReviewForm($user);
  }else{                                //NO account
    drawFilterBar($user); 
  }
  if (!isset($_GET['classification'])) drawReviews($user, -1);
  else drawReviews($user, $_GET['classification']);

  drawHamburguer($session, 0);
  drawFilterBar($session);
  if (!isset($_GET['classification'])) drawReviews($session, -1);
  else drawReviews($session, $_GET['classification']);
  drawFooter();
