<?php
include_once('connection_to_db.php');

function getUser($email, $password, $db) {
    $stmt = $db->prepare('
        SELECT idUser, firstName, lastName, phone, email, userPassword, stars, photo, idCountry, city, userAddress, zipCode
        FROM User 
        WHERE lower(email) = ? AND userPassword = ?
    ');

    $stmt->execute(array(strtolower($email), password_hash($password, PASSWORD_DEFAULT)));

    if ($user = $stmt->fetch()) {
        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['phone'],
            $user['email'],
            $user['userPassword'],
            $user['stars'],
            $user['photo'],
            $user['idCountry'],
            $user['city'],
            $user['userAddress'],
            $user['zipCode']
        );
    } else {
        return null;
    }
}
?>