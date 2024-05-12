<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/product.class.php');

  $db = getDatabaseConnection();

  $product = getProduct($_GET['id']);
  $photos = $product->getPhotos();

  echo json_encode($photos);
