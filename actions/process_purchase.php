
<?php
    require_once(__DIR__. '/../database/get_from_db.php');
    require_once(__DIR__ . '/../sessions/session.php');
    require_once(__DIR__ . '/../database/addressInfo.php');

    $session = new Session();
    $user = $session->getUser();
    $db = getDatabaseConnection();
    $country = $_POST['country'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];

    if ($_POST['paymentAuthhorization'] !== $session->getCSRF() or
        !isset($country) or !isset($city) or !isset($address) or !isset($zipcode))
    {
        //Suspicious transaction
        //TODO card payment
        //TODO change == to ===
        //TODO update sql so that reviews only go up to minutes

        header('Location: ../pages/cart_page.php');
    }
    
    $country =  trim($country);
    $city    =  trim($city);
    $address =  trim($address);
    $zipcode =  trim($zipcode);

    $db->beginTransaction();
    $items = $user->getShoppingCart();
    $products = array();
    $buyerAddressInfo = new ShippingAddressInfo($country,$city,$address,$zipcode);

    $total = 0;
    foreach ($items as $item){
        $products[] = getProduct($item);
    }
    $date = date('Y-m-d');
    foreach($products as $product) {
        addShipping($db, $product, $user, $product->getSeller(), $buyerAddressInfo, $date, $product->price);
        if ($product->getBuyer() !== null) {
            $db->rollBack();
            header('Location: /../pages/errorPage.php?error=Tried_to_buy_bought_item');
        }else{
            removeFromCarts($db, $product->id);
            removeFromRecent($db, $product->id);            
            removeFromFavorites($db, $product->id);
            $buyer = $session->getUser();

            uppdateBuyer($db,$product->id ,$user->id);

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
    function removeFromRecent(PDO $db, int $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Recent
                            WHERE product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function removeFromFavorites(PDO $db, int $item) {
        $stmt = $db->prepare('DELETE 
                            FROM Favorites
                            WHERE product = ? ');
        $stmt->execute(array($item));
    }
?>

<?php
    function addShipping(PDO $db, Product $product, User $buyer, User $seller, ShippingAddressInfo $buyerAddressInfo, string $date, int $total) {
        $query = $db->prepare('SELECT idShipping
                                FROM Shipping
                                WHERE purchaseDate = ? AND buyer = ? AND seller = ?');
        $query->execute(array($date, $buyer->id, $seller->id));
        $shipping = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($shipping)) {
            $stmt = $db->prepare('  INSERT INTO Shipping (buyer, buyerCountry, buyerCity, buyerAddress, buyerZipCode,
                                    seller, sellerCountry, sellerCity, sellerAddress, sellerZipCode,
                                    purchaseDate, total)
                                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?);
                                ');

            $stmt->execute(array($buyer->id, $buyerAddressInfo->country, $buyerAddressInfo->city, $buyerAddressInfo->address, $buyerAddressInfo->zipCode,
                                    $seller->id, $seller->getCountry(), $seller->city, $seller->userAddress, $seller->zipCode,
                                    $date, 0));
            $shippingId = $db->lastInsertId();
        }else{
            $shippingId = $shipping['idShipping'];
        }
        

        $stmt = $db->prepare(' UPDATE Product
                                SET shipping = ?
                                WHERE idProduct = ?');
        $stmt->execute(array($shippingId,$product->id));

        $stmt = $db->prepare(' UPDATE Shipping
                                SET total = total + ?
                                WHERE idShipping = ?');
        $stmt->execute(array($product->price,$shippingId));
    }

?>

<?php
    function uppdateBuyer(PDO $db, int $item, string $buyer) {


        $stmt = $db->prepare('UPDATE Product 
                                SET buyer = (?)
                                WHERE idProduct=(?);
                              ');
        $stmt->execute(array($buyer, $item));
    }
?>