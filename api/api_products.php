<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');
  require_once(__DIR__ . '/../database/productClass.php');

  $db = getDatabaseConnection();

  $artists = Product::searchProduct($_GET['search']);

  echo json_encode($artists);
