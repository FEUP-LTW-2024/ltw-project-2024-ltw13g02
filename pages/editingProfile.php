<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/user_tmpl.php');

  $db = getDatabaseConnection();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newPhone = $_POST['phone'];
    $newAddress =  $_POST['address'];
    $newCity = $_POST['city'];
    //$newCountry = $_POST['country'];
    $newZipCode = $_POST['zipCode'];
    

    $session->setFirstName($newFirstName);
    $session->setLastName($newLastName);
    $session->setPhone($newPhone);
    $session->setAddress($newAddress);
    $session->setCity($newCity);
    //$session->setCountry($userCountry);
    $session->setZipCode($newZipCode);

    //&country=$newIdCountry
    header("Location: /../actions/editingProfileAction.php?first_name=$newFirstName&last_name=$newLastName&phone=$newPhone&address=$newAddress&city=$newCity&zipCode=$newZipCode");
    exit();
}

  drawHeader($session);
  drawHamburguer($session, 0);
  drawEditProfile($session);
  drawFooter();
?>