<?php
include_once('../database/connection_to_db.php');
include_once('../database/get_from_db.php');
include_once('../sessions/session.php');
$session = new Session();


try {
    $idUser = uniqid() . bin2hex(random_bytes(2));
    $fullName = $_POST['name'];
    $names = explode(' ', $fullName);
    $firstName = $names[0];
    $lastName = isset($names[1]) ? $names[1] : '';
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $idCountry = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zipCode = $_POST['zipCode'];

    $db = getDatabaseConnection();

    $stmt = $db->prepare("INSERT INTO User (idUser, firstName, lastName, phone, email, userPassword, idCountry, city, userAddress, zipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($idUser, $firstName, $lastName, $phone, $email, $password, $idCountry, $city, $address, $zipCode));

    $user = getUserbyId($idUser);
    $session->setUser($user);

    header("Location: ../pages");
    exit;
} catch (PDOException $e) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Location: ../pages/register.php");
    exit;
}

