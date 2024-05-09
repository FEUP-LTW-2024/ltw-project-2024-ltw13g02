<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');
  

  require_once(__DIR__ . '/../templates/edit_tmpl.php');

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newPhone = $_POST['phone'];
    $newAddress =  $_POST['address'];
    $newCity = $_POST['city'];
    $newCountry = $_POST['country'];
    $newZipCode = $_POST['zipCode'];
    

    //photo upload
    $photoDir = __DIR__ . '/../images/userProfile/';
    $userId = $session->getUser()->getId(); 
    $photoExtension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
    $photoName = $userId . '.' . $photoExtension;
    $photoPath = $photoDir . $photoName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($photoPath, PATHINFO_EXTENSION));

    if($_FILES["photo"]["name"] != null){

      if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
         } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
      }

      if ($_FILES["photo"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }

      if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
          && $imageFileType != "gif") {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }

      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded.";
      } else {
          if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {
              echo "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
    } else {
      $photoName = $session->getUser()->getPhoto();
    }
    

  if ($uploadOk == 1) {
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

    header("Location: /../actions/editingProfileAction.php?first_name=$newFirstName&last_name=$newLastName&phone=$newPhone&address=$newAddress&city=$newCity&country=$newCountry&zipCode=$newZipCode&photo=$photoName");
    exit();
  }
}

  drawHeader($session);
  drawHamburguer($session, 0);
  drawEditProfile($session);
  drawFooter();
?>