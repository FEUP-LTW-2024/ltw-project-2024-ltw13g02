<?php

require_once(__DIR__ . "/../sessions/session.php");
require_once(__DIR__ . "/../database/get_from_db.php");
require_once(__DIR__ . "/../database/connection.db.php");
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

    if($favorites != null && in_array($product->id, $favorites)) {
        $stmt = $db->prepare('DELETE
                              FROM Favorites
                              WHERE user = ? and product = ?;');
        $stmt->execute(array($user->id, $product->id));
    } else {
        $stmt = $db->prepare('INSERT INTO Favorites (user, product)
                              VALUES(?,?);');
        $stmt->execute(array($user->id, $product->id));
    }

    header("Location: ../pages/productPage.php?product={$product->id}");
} else {
    header('Location: ../pages/index.php');
}
