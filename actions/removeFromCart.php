<?php
    require_once(dirname(__FILE__) ."/../database/connection_to_db.php");
    $db = getDatabaseConnection();
    $itemId = $_POST["product"];
    $userId = $_POST["user"];
    echo"OUT";
    if(isset($userId) and isset($itemId)) {
        echo"INSIDE";
        $stmt = $db->prepare("DELETE
                        FROM ShoppingCart
                        WHERE user = ? and product = ?;");
        $stmt->execute(array($userId, $itemId));
    }
    header('Location: ../pages/cart_page.php');
