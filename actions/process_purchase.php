
<?php
    require_once('database/connection.php');
    $session = new Session();
    $db = getDatabaseConnection();
    $db->beginTransaction();
    $items = getUserShopingCart($db, $SESSION['idUser']);
    foreach($items as $item) {
        $db_item = get_product($db,$item['idProduct']);
        if ($db_item['buyer'] !== null) {
            $db->rollBack();

            header('Location: ../pages/errorPage.php?error=Tried_to_buy_bought_item');
        }else{
            removeFromCarts($db, $item);
            removeFromRecent($db, $item);
            removeFromFavorites($db, $item);
            //addShiping();
            //addMessage();
            //uppdateBuyer();

        }
    }
    $db->commit();
    header('Location: ../pages/cart_page.php');
?>

<?php
    function removeFromCarts(PDO $db, $item) {
        $stmt = $db->prepare('DELETE 
                            FROM ShoppingCart SP
                            WHERE SP.product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function removeFromRecent(PDO $db, $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Recent R
                            WHERE R.product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function removeFromFavorites(PDO $db, $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Favorites F
                            WHERE F.product = ? ');
        $stmt->execute(array($item));
    }
?>