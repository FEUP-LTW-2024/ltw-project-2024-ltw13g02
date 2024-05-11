<?php
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection_to_db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $user = getUserbyemail($email);

    if ($user) {
        $stmt = $db->prepare("INSERT INTO UserAdmin(idUser) VALUES (?)");
        $stmt->execute(array($user->getId()));
    }

    header("Location: /../pages/adminPage.php");
    exit();
}