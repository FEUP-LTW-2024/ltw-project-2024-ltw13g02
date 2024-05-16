<?php
include_once('../database/connection.db.php');
include_once('../database/get_from_db.php');
require_once('../database/product.class.php');
include_once('../sessions/session.php');
$session = new Session();
$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $prodName = $_GET['prodName'];
    $prodDescription = $_GET['prodDescription'];
    $price = $_GET['price'];
    $condition = $_GET['condition'];
    $characteristic1 = $_GET['characteristic1'] ?? null;
    $characteristic2 = $_GET['characteristic2'] ?? null;
    $characteristic3 = $_GET['characteristic3'] ?? null;
    $photosProd = $_GET['photosProd'];
    $seller = $session->getUser()->id;


    $stmt = $db->prepare("INSERT INTO Product (prodName, prodDescription, price, condition, characteristic1, characteristic2, characteristic3, seller) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute(array($prodName, $prodDescription, $price, $condition, $characteristic1, $characteristic2, $characteristic3, $seller));

    $stmt = $db->prepare('
            SELECT Product.idProduct
            FROM Product
            WHERE Product.prodName = ?
            AND Product.prodDescription = ?
        ');
    $stmt->execute(array($prodName, $prodDescription));
    $prodId = $stmt->fetch();


    if($photosProd != null){
        $photoName = basename($photosProd);
        $stmt = $db->prepare("INSERT INTO Photo (idProduct, photo) VALUES (?, ?)");
        $stmt->execute(array($prodId['idProduct'], $photoName));
    }
    
    header("Location: ../pages/myAnnouncements.php");
    exit;
}
?>
