<?php
require_once(__DIR__ . '/connection_to_db.php');
require_once(__DIR__ . '/userClass.php');

    
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

function getCountryFromDB($idCountry) : ?string {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT country FROM Country WHERE idCountry = ?');
    $stmt->execute(array($idCountry));
    $country = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($country['country']) ? $country['country'] : null;
}
