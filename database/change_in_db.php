<?php
include_once('connection_to_db.php');

function addUser(int $idUser, string $firstName, string $lastName, string $phone, string $email, string $password, string $address, string $city, string $idCountry, string $zipCode) {
    $db = getDatabaseConnection();

    $options = ['cost' => 12];

    $stmt = $db->prepare('INSERT INTO User(idUser, firstName, lastName, phone, email, address, 0, photo, city, idCountry, zipCode) VALUES(:idUser, :firstName, :lastName, :phone, :email, :address, :stars, :photo, :city, :idCountry, :zipCode)');
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':firstName', $firstName);
    $stmt->bindParam(':lastName', $lastName);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':address', $address);
    $i = 0;
    $stmt->bindParam(':stars', $i);
    $stmt->bindParam(':photo', $photo);
    $stmt->bindParam(':city', $city);
    $stmt->bindParam(':idCountry', $idCountry);
    $stmt->bindParam(':zipCode', $zipCode);
    $password_hash = password_hash($password, PASSWORD_BCRYPT, $options);
    $stmt->bindParam(':password', $password_hash);

    $stmt->execute();
}

function setAsSeen($idChat, $idUser) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('UPDATE Messages SET seen=1 WHERE sender <> ? AND chat = ?');
    $stmt->execute(array($idUser, $idChat));
}

function addMessage($idUser, $idChat, $content) {
    // Check if content is empty or NULL
    if (empty($content)) {
        throw new Exception("Content cannot be empty");
    }
    
    $db = getDatabaseConnection();
    $date = date('Y-m-d H:i:s');
    $stmt = $db->prepare('INSERT INTO Messages (messageDate, sender, chat, content, seen) VALUES (?, ?, ?, ?, 0)');
    $stmt->execute(array($date, $idUser, $idChat, $content));
}

