<?php

require_once(__DIR__ . "/../sessions/session.php");
require_once(__DIR__ . "/../database/get_from_db.php");
require_once(__DIR__ . "/../database/connection_to_db.php");
require_once(__DIR__ . "/../database/get_from_db.php");

if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['product'])) {
    header('Location: ../index.php');
}

$session = new Session();
$db = getDatabaseConnection();
if (!$session->isLoggedIn()) {
    header('Location: ../pages/index.php');
}

$user = $session->getUser();
$product = getProduct($_GET['product']);

if(isset($product) && isset($user)){
    $favorites = $user->getFavorites();

    if($favorites != null && in_array($product->getId(), $favorites)) {
        $stmt = $db->prepare('DELETE
                              FROM Favorites
                              WHERE user = ? and product = ?;');
        $stmt->execute(array($user->getId(), $product->getId()));
    } else {
        $stmt = $db->prepare('INSERT INTO Favorites (user, product)
                              VALUES(?,?);');
        $stmt->execute(array($user->getId(), $product->getId()));
    }

    header("Location: ../pages/productPage.php?product={$product->getId()}");
} else {
    header('Location: ../pages/index.php');
}
