
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
            //TODO add adaptar tamanho tela diferentes
            addShiping($db,$product->idProduct,$session->getId(),$product->seller);
            //sendMessage();  TODO descobrir se fazer isto ou não
            uppdateBuyer($db,$product->idProduct ,$session->getId());

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
    function addShiping(PDO $db, int $item, int $buyer, int $seller) {
        $stmt = $db->prepare('INSERT INTO Shipping (product, buyer, seller, purchaseDate)
                                VALUES (?,?,?,?);
                              ');
        $stmt->execute(array($item, $buyer, $seller, date('Y-m-d')));
    }

?>

<?php
    function uppdateBuyer(PDO $db, int $item, int $buyer) {


        $stmt = $db->prepare('UPDATE Product 
                                SET buyer = (?), purchaseDate = (?)
                                WHERE idProduct=(?);
                              ');
        $stmt->execute(array($buyer, date('Y-m-d'), $item));
    }

?>