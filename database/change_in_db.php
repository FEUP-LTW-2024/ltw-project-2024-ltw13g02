<?php
include_once('connection_to_db.php');

function addUser(int $idUser, string $firstName, string $lastName, string $phone, string $email, string $password, string $address, string $city, string $idCountry, string $zipCode) {
    $db = getDatabaseConnection();

    $options = ['cost' => 12];

    $stmt = $db->prepare('INSERT INTO User(idUser, firstName, lastName, phone, email, address, 0, city, idCountry, zipCode) VALUES(:idUser, :firstName, :lastName, :phone, :email, :address, :stars, :city, :idCountry, :zipCode)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $i = 0;
    $stmt->bindParam(':stars', $i);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':idCountry', $idCountry);
    $stmt->bindParam(':zipCode', $zipCode);
    $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
    $stmt->bindParam(':password', $password_hash);

    $stmt->execute();
}

function deleteUser($username) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('DELETE FROM user WHERE idUser=:idUser');
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
}
