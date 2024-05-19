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
  $classification = $_GET['classification'];
  if (!isset($classification) || !preg_match("/^[0-5]+$/",$classification)) {$classification=-1;}
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
  if ($classification == -1) drawReviews($user, -1);
  else drawReviews($user, $classification);

  drawFooter();
