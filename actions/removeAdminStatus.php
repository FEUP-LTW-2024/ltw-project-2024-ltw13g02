<?php
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    $user = getUserbyemail($email);

    if ($user) {
        $stmt = $db->prepare("DELETE FROM UserAdmin WHERE idUser=?");
        $stmt->execute(array($user->id));
    }

    header("Location: /../pages/adminPage.php");
    exit();
}