<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SESSION['csrf'] !== $_POST['csrf']) header('Location: ../pages/errorPage.php?error=noAuthorizationAccess');

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $newPassword = password_hash($_GET['password'], PASSWORD_BCRYPT);

    $email = $session->getUser()->email;
    updateUserPassword($session, $email, $newPassword);

    header("Location: /../pages/profilePage.php");
    exit();
}


function updateUserPassword(Session $session, string $email, string $newPassword) { 
    $db = getDatabaseConnection();
    $user = $session->getUser();
    $stmt = $db->prepare('UPDATE User SET userPassword = :userPassword WHERE email = :email');
    $stmt->execute(array(':userPassword' => $newPassword, ':email' => $email));
    
    $session->setUser(getUserbyId($user->id));
}
