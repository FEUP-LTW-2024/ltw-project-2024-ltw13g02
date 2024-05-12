<?php
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $characteristic = $_POST['characteristic'];
    $type = $_POST['type'];

    $stmt = $db->prepare("INSERT INTO Characteristic (idType, characteristic) VALUES (?, ?)");
    $stmt->execute(array($type, $characteristic));

    header("Location: /../pages/adminPage.php");
    exit();
}