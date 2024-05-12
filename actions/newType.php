<?php
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $type = $_POST['type'];

    $stmt = $db->prepare("INSERT INTO TypesInCategory (type_name, category) VALUES (?, ?)");
    $stmt->execute(array($type, $category));

    header("Location: /../pages/adminPage.php");
    exit();
}