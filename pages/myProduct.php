<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/product.tpl.php');

$db = getDatabaseConnection();

/*if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['product'])) {
  header('Location: ../pages/index.php');
}*/


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prodName = $_POST['prodName'];
    $prodDescription = $_POST['prodDescription'];

    $price = $_POST['price'];
    $price = str_replace(',', '.', $price);
    $price = floatval($price);

    $idProduct = $_POST['product_id'];
    

    header("Location: ../actions/editProdAction.php?prodName=$prodName&prodDescription=$prodDescription&price=$price&idProduct=$idProduct");
    exit;
}

$db = getDatabaseConnection();

$idProduct = $_GET['product'];
drawHeader($session);
drawProductHeader($session, $idProduct);
drawEditProduct($session, $idProduct);
?>
<div class = "edit" > 
<?php drawFooter();?>
</div>
    
