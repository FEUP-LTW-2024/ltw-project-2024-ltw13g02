<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

if(isset($_POST['email']) && isset($_POST['password'])) {
    $user = getUser($_POST['email'], $_POST['password']);
    if ($user && $_POST['email'] == $session->getUser()->email) {
        $session->addMessage('success', 'Confirm Login successful!');
        header("Location: ../pages/changeEmailOrPassword.php");
    } else {
        $session->addMessage('error', 'Wrong email or password!');
        header("Location: ../pages/confirmLogin.php");
    }
}
else {
    $session->addMessage('error', 'Email or password not provided!');
    header("Location: ../pages/confirmLogin.php");
}
exit;
