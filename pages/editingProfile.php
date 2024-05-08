<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/user_tmpl.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newPhone = $_POST['phone'];
    $newAddress =  $_POST['address'];
    $newCity = $_POST['city'];
    $newCountry = $_POST['country'];
    $newZipCode = $_POST['zipCode'];
    
    $user = $session->getUser();
    $user->setFirstName($newFirstName);
    $user->setLastName($newLastName);
    $newPhone = intval($newPhone);
    $user->setPhone($newPhone);
    $user->setAddress($newAddress);
    $user->setCity($newCity);

    $db = getDatabaseConnection();
    
    $stmt = $db->prepare('SELECT idCountry FROM Country WHERE country = ?');
    $stmt->execute(array($newCountry));
    $country = $stmt->fetch(PDO::FETCH_ASSOC);    
    if ($country) {
        $user->setCountry((int)$country['idCountry']);
        $newCountry = (int)$country['idCountry'];
    } else {
        return; // Country Invalid
    }

    $user->setZipCode($newZipCode);

    header("Location: /../actions/editingProfileAction.php?first_name=$newFirstName&last_name=$newLastName&phone=$newPhone&address=$newAddress&city=$newCity&country=$newCountry&zipCode=$newZipCode");
    exit();
}

  drawHeader($session);
  drawHamburguer($session, 0);
  drawEditProfile($session);
  drawFooter();