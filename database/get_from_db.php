<?php
include_once('connection_to_db.php');

function checkUserPassword($idUser, $password): bool {
    $db = getDatabaseConnection();

    $stmt = $db->prepare('SELECT * FROM user WHERE idUser = :idUser');
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();

    $user = $stmt->fetch();
    return $user !== false && password_verify($password, $user['password']);
}
function getUser($idUser) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM user WHERE idUser=:idUser');
    $stmt->bindParam(':username', $idUser);
    $stmt->execute();
    return $stmt->fetch();
}