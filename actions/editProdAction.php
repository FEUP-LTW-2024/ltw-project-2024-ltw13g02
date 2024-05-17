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
    

    $idProduct = $_GET['idProduct'];

    updateProd($idProduct, $prodName, $prodDescription, $price);

    header("Location: ../pages/myAnnouncements.php");
    exit;
}



function updateProd(string $idProduct, string $prodName, string $prodDescription, float $price) { 
    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE Product SET prodName = :prodName, prodDescription = :prodDescription, price = :price WHERE idProduct = :idProduct");
    $stmt->execute(array(':prodName' => $prodName, ':prodDescription' => $prodDescription, ':price' => $price, ':idProduct' => $idProduct));
}
