
<?php
    require_once('database/connection.php');
    $db = getDatabaseConnection();
    $db->beginTransaction();
    $items = getUserShopingCart($db, $SESSION['idUser']);
    foreach($items as $item) {
        $db_item = get_product($db,$item['idProduct']);
        if ($db_item['buyer'] !== null) {
            $db->rollBack();
            remove_already_bought_items($db, $items ,$SESSION['idUser']);
            header('Location: cart.php');
        }else{

        }
    }
    $db->commit();
    header('Location: main.html');
?>

<?php
function remove_already_bought_items($db, $items ,$user_id) {
    $productsIds = array();
    foreach($items as $item) {
        if ($item['buyer'] != null) {
            array_push($products, $item['idProduct']);
        }
    }


    $stmt = $db->prepare('DELETE
                            FROM ShoppingCart SC 
                            WHERE SC.user = ? and SC.product in (?)');
    $stmt->execute(array( $user_id, $productsIds ) );
    }
?>