<?php
require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];

    $stmt = $db->prepare("INSERT INTO Category (category) VALUES (?)");
    $stmt->execute(array($category));

    header("Location: /../pages/adminPage.php");
    exit();
}