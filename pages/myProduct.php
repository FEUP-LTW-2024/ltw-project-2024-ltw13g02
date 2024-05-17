<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/product.tpl.php');

$db = getDatabaseConnection();

if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['product'])) {
  header('Location: ../pages/index.php');
}

/*if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prodName = $_POST['prodName'];
    $prodDescription = $_POST['prodDescription'];
    $price = $_POST['price'];

    header("Location: ../actions/editProdAction.php?prodName=$prodName&prodDescription=$prodDescription&price=$price&condition=$condition&characteristic1=$char1&characteristic2=$char2&characteristic3=$char3&photosProd=$photoName");
    exit;
}*/

$db = getDatabaseConnection();
$idProduct = $_GET['product'];

drawHeader($session);
drawProductHeader($session, $idProduct);
drawEditProduct($session, $idProduct);
drawFooter();
?>
