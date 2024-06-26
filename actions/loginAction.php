<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

if(isset($_POST['email']) && isset($_POST['password'])) {
    $user = getUser($_POST['email'], $_POST['password']);
    if ($user) {
        $session->setUser($user);
        $session->addMessage('success', 'Login successful!');
        header("Location: ../pages");
    } else {
        $session->addMessage('error', 'Wrong email or password!');
        header("Location: ../pages/login.php");
    }
}
else {
    $session->addMessage('error', 'Email or password not provided!');
    header("Location: ../pages/login.php");
}
exit;
