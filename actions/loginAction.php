<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');
  require_once(__DIR__ . '/../database/userClass.php');

  $db = getDatabaseConnection();

  $customer = User::getCustomerWithPassword($db, $_POST['email'], $_POST['password']);

  if ($customer) {
    $session->setId($customer->id);
    $session->setName($customer->name());
    $session->addMessage('success', 'Login successful!');
  } else {
    $session->addMessage('error', 'Wrong password!');
  }

  header("Location: ../pages/index.php");;
