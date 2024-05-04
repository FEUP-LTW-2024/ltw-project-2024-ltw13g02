<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection_to_db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $newFirstName = $_GET['first_name'];
    $newLastName = $_GET['last_name'];
    $newPhone = $_GET['phone'];
    $newAddress =  $_GET['address'];
    $newCity = $_GET['city'];
    //$newCountry = $_GET['country'];
    $newZipCode = $_GET['zipCode'];


    $email = $session->getEmail();
    updateUser($db, $email, $newFirstName, $newLastName,  $newPhone, $newAddress, $newCity/*, $newCountry*/, $newZipCode);

    header("Location: /../pages/profilePage.php");
    exit();
}


function updateUser(PDO $db, string $email, string $newFirstName, string $newLastName, string $newPhone, string $newAddress, string $newCity/*, string $newCountry*/, string $newZipCode) {
    $newPhone = intval($newPhone);
    /*$stmt = $db->prepare('SELECT idCountry FROM Country WHERE country = ?');
    $stmt->execute(array($idCountry));
    $country = $stmt->fetch(PDO::FETCH_ASSOC);*/
    $stmt = $db->prepare('UPDATE User SET firstName = :firstName, lastName = :lastName, phone = :phone, userAddress = :address, city = :city, zipCode = :zipCode  WHERE email = :email');
    $stmt->execute(array(':firstName' => $newFirstName, ':lastName' => $newLastName, ':email' => $email, ':phone' => $newPhone, ':address' => $newAddress, ':city' => $newCity/*, ':idCountry' => $country*/, ':zipCode' => $newZipCode));
} ?>