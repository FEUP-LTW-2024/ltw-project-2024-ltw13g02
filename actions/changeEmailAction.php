<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SESSION['csrf'] !== $_POST['csrf']) header('Location: ../pages/errorPage.php?error=noAuthorizationAccess');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $newEmail = $_GET['email'];

    $id = $session->getUser()->id;
    updateUserPassword($session, $id, $newEmail);

    header("Location: /../pages/profilePage.php");
    exit();
}


function updateUserPassword(Session $session, string $id, string $newEmail) { 
    $db = getDatabaseConnection();
    $user = $session->getUser();
    $stmt = $db->prepare('UPDATE User SET email = :email WHERE idUser = :id');
    $stmt->execute(array(':id' => $id, ':email' => $newEmail));
    
    $session->setUser(getUserbyId($user->id));
}
