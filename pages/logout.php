<?php
require_once(__DIR__ . '/../sessions/session.php');

$session = new Session();
$session->logout();

header("Location: ../pages");
exit;

