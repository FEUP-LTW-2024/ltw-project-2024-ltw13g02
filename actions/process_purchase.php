
<?php
    require_once(__DIR__. '/../database/get_from_db.php');
    require_once(__DIR__ . '/../sessions/session.php');


    $session = new Session();
    $user = $session->getUser();
    $db = getDatabaseConnection();
    $db->beginTransaction();
    $items = $user->getShoppingCart();
    if ($_POST['paymentAuthhorization'] !== 'paymentAuthorized')
    {
        header('Location: ../pages/cart_page.php');
    }
    foreach($items as $item) {
        $product = getProduct($item);

        if ($product->getBuyer() !== null) {
            $db->rollBack();
            header('Location: ../pages/errorPage.php?error=Tried_to_buy_bought_item');
        }else{
            

            removeFromCarts($db, $product->getId());
            removeFromRecent($db, $product->getId());            
            removeFromFavorites($db, $product->getId());
            $user = $session->getUser();
            addShiping($db,$product->getId(),$user->getId(),$product->getSeller()->getId());
            uppdateBuyer($db,$product->getId() ,$user->getId());

        }
    }
    $db->commit();
    header('Location: ../pages/cart_page.php');
?>

<?php
    function removeFromCarts(PDO $db, int $item) {
        $stmt = $db->prepare('DELETE 
                            FROM ShoppingCart
                            WHERE product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function removeFromRecent(PDO $db, $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Recent
                            WHERE product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function removeFromFavorites(PDO $db, $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Favorites
                            WHERE product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php

    function addShiping(PDO $db, int $item, string $buyer, string $seller){
        $stmt = $db->prepare('INSERT INTO Shipping (product, buyer, seller, purchaseDate)
                                VALUES (?,?,?,?);
                              ');
        $stmt->execute(array($item, $buyer, $seller, date('Y-m-d')));
    }

?>

<?php
    function uppdateBuyer(PDO $db, int $item, string $buyer) {


        $stmt = $db->prepare('UPDATE Product 
                                SET buyer = (?), purchaseDate = (?)
                                WHERE idProduct=(?);
                              ');
        $stmt->execute(array($buyer, date('Y-m-d'), $item));
    }
?>