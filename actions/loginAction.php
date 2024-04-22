<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection_to_db.php');
require_once(__DIR__ . '/../database/get_from_db.php');

$user = getUser($_POST['email'], $_POST['password'], $db);

if ($user) {
    $session->setId($user->id);
    $session->setName($user->name());
    $session->addMessage('success', 'Login successful!');
} else {
    $session->addMessage('error', 'Wrong password!');
}

header("Location: ../pages");
exit;

?>