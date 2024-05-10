<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection_to_db.php');
$db = getDatabaseConnection();


if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $newFirstName = $_GET['first_name'];
    $newLastName = $_GET['last_name'];
    $newPhone = $_GET['phone'];
    $newAddress =  $_GET['address'];
    $newCity = $_GET['city'];
    $newCountry = $_GET['country'];
    $newZipCode = $_GET['zipCode'];
    $photoName = $_GET['photo'];


    $email = $session->getUser()->getEmail();
    updateUser($session, $email, $newFirstName, $newLastName, $newPhone, $newAddress, $newCity, $newCountry, $newZipCode, $photoName);

    header("Location: /../pages/profilePage.php");
    exit();
}


function updateUser(Session $session, string $email, string $newFirstName, string $newLastName, string $newPhone, string $newAddress, string $newCity, string $newCountry, string $newZipCode, string $photoName) { 
    $db = getDatabaseConnection();
    $user = $session->getUser();
    $stmt = $db->prepare('UPDATE User SET firstName = :firstName, lastName = :lastName, phone = :phone, userAddress = :address, city = :city, idCountry = :idCountry, zipCode = :zipCode, photo = :photoName WHERE email = :email');
    $stmt->execute(array(':firstName' => $newFirstName, ':lastName' => $newLastName, ':email' => $email, ':phone' => $newPhone, ':address' => $newAddress, ':city' => $newCity, ':idCountry' => $newCountry, ':zipCode' => $newZipCode, ':photoName' => $photoName));
    
    $session->setUser(getUserbyId($user->getId()));
}
