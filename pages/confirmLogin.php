<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/edit_tmpl.php');

  /*if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newFirstName = $_POST['first_name'];
    
    $user = $session->getUser();
    $user->setFirstName($newFirstName);
    

    header("Location: /../actions/editingProfileAction.php?first_name=$newFirstName&last_name=$newLastName&phone=$newPhone&address=$newAddress&city=$newCity&country=$newCountry&zipCode=$newZipCode&photo=$photoName");
    exit();
}*/

  drawHeader($session);
  drawHamburguer($session, 0);
  drawConfirmLogIn($session);
  drawFooter();
?>