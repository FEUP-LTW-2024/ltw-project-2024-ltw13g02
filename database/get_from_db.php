<?php
require_once('connection_to_db.php');
require_once(__DIR__ . '/../database/userClass.php');


function getUser($email, $password) : ?User{

    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT idUser, firstName, lastName, phone, email, stars, photo, userPassword, idCountry, city, userAddress, zipCode
        FROM User 
        WHERE lower(email) = ?
    ');

    $stmt->execute(array(strtolower($email)));

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['userPassword'])) {
        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['phone'],
            $user['email'],
            $user['userAddress'],
            $user['stars'],
            $user['city'],
            $user['idCountry'],
            $user['photo'],
            $user['zipCode'],
        );
    } else {
        return null;
    }
}

function getCountryFromDB($countryNumber) : ?string {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT country FROM Country LIMIT ?, 1');
    $stmt->execute(array($countryNumber - 1)); // Adjust the country number to match the row index (starting from 0)
    $country = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
    return isset($country['country']) ? $country['country'] : null; // Access the country name
}
