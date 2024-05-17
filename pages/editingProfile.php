<?php
  declare(strict_types = 1);
  
  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  

  require_once(__DIR__ . '/../templates/edit.tpl.php');

  if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $newFirstName = $_POST['first_name'];
    $newLastName = $_POST['last_name'];
    $newPhone = $_POST['phone'];
    $newAddress =  $_POST['address'];
    $newCity = $_POST['city'];
    $newCountry = $_POST['country'];
    $newZipCode = $_POST['zipCode'];
    

    //photo upload
    $photoDir = __DIR__ . '/../images/userProfile/';
    $userId = $session->getUser()->id; 
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

      if ($uploadOk === 0) {
          echo "Sorry, your file was not uploaded.";
      } else {
          if (move_uploaded_file($_FILES["photo"]["tmp_name"], $photoPath)) {
              echo "The file " . htmlspecialchars(basename($_FILES["photo"]["name"])) . " has been uploaded.";
          } else {
              echo "Sorry, there was an error uploading your file.";
          }
      }
    } else {
      $photoName = $session->getUser()->photo;
    }
    

    if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $newFirstName) ||
        !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $newLastName) ||
        !preg_match("/^\d{9}$/", $newPhone) ||
        !preg_match("/^[a-zA-ZÀ-ÿ\s\-\.\*]+$/u", $newAddress) ||
        !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $newCountry) ||
        !preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $newCity) ||
        !preg_match("/^[0-9\-]+$/", $newZipCode)) { 
        
        echo "Invalid Input.";
        exit();
    }

    $user = $session->getUser();
    $user->firstName = $newFirstName;
    $user->lastName = $newLastName;
    $newPhone = intval($newPhone);
    $user->phone = $newPhone;
    $user->userAddress = $newAddress;
    $user->city = $newCity;

    $db = getDatabaseConnection();
    
    $stmt = $db->prepare('SELECT idCountry FROM Country WHERE country = ?');
    $stmt->execute(array($newCountry));
    $country = $stmt->fetch(PDO::FETCH_ASSOC);    
    if ($country) {
        $user->country = (int)$country['idCountry'];
        $newCountry = (int)$country['idCountry'];
    } else {
        return; // Country Invalid
    }

    $user->zipCode = $newZipCode;

    header("Location: /../actions/editingProfileAction.php?first_name=$newFirstName&last_name=$newLastName&phone=$newPhone&address=$newAddress&city=$newCity&country=$newCountry&zipCode=$newZipCode&photo=$photoName");
    exit();
  }

  drawHeader($session);
  drawHamburguer($session, 0);
  drawEditProfile($session);
  drawFooter();
?>
