<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../database/user.class.php');

require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/productsprint.tpl.php');
require_once(__DIR__ . '/../templates/shippment.tpl.php');

$db = getDatabaseConnection();
$session = new Session();

if (!isset($_GET['shipping'])) {
  header('Location: ../index.php');
}
if (!preg_match("/^[0-9]+$/", $_GET['shipping'])) {
  header('Location: ../index.php');
}
$shipping = getShipping((int) $_GET['shipping']);
$user = $session->getUser();

if ($session->isLoggedIn() and $shipping->seller->id === $user->id) {
  drawHeader($session);
  ?>  <link rel="stylesheet" href="../css/shipping.css"> <?php
  drawShippingHeader($shipping->purchaseDate);
  drawShippingProducts($shipping);
  drawShippingUsers($shipping);
  drawFooter();

}
?>
