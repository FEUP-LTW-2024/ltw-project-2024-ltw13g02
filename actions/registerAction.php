<?php
include_once('../database/connection_to_db.php');

try {
    $fullName = $_POST['name'];
    $names = explode(' ', $fullName);
    $firstName = $names[0];
    $lastName = isset($names[1]) ? $names[1] : '';
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
<<<<<<< HEAD
    $idCountry = $_POST['country'];
=======
    $idCountry = $_POST['idCountry'];
>>>>>>> 50e0deedde3edd973f32d7675025b17d2c7d9da1
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zipCode = $_POST['zipCode'];

    $db = getDatabaseConnection();

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    var_dump($_POST);
    $stmt = $db->prepare("INSERT INTO User (firstName, lastName, phone, email, userPassword, idCountry, city, userAddress, zipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstName, $lastName, $phone, $email, $password, $idCountry, $city, $address, $zipCode]);

    $db = null;

    header("Location: ../pages");
    exit;
} catch (PDOException $e) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header("Location: ../pages/register.php");
    exit;
}
?>
