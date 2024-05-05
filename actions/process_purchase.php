
<?php
    require_once(__DIR__. '/../database/connection.php');
    require_once(__DIR__ . '/../sessions/session.php');


    $session = new Session();

    $db = getDatabaseConnection();
    $db->beginTransaction();
    $items = getUserShopingCart($db, $session->getId());
    foreach($items as $item) {
        $product = build_Product_from_id($db,$item['product']);
        if ($product->buyer !== null) {
            $db->rollBack();

            header('Location: ../pages/errorPage.php?error=Tried_to_buy_bought_item');
        }else{
            


            removeFromCarts($db, $product->idProduct);
            removeFromRecent($db, $product->idProduct);            
            removeFromFavorites($db, $product->idProduct);
            //addShiping(); TODO
            //addMessage();
            //uppdateBuyer();

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