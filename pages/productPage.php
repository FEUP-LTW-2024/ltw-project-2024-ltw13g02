<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/product.tpl.php');

  if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['product'])) {
    header('Location: pages/index.php');
  }

  drawHeader($session);
  $product = getProduct($_GET['product']);

if($product === null){ ?>
    <br>
    <h2 class = "notAvailable"><?php echo "This product is not available!"; ?></h2>
<?php } else {
    if($product->getBuyer() != null && $product->getSeller() === $session->getUser()->id) {
        header('Location: ../pages/shipmentPage.php');
    } else if($product->getBuyer() != null) { ?>
        <br>
        <h2 class = "notAvailable"><?php echo "This product is not available!"; ?></h2>
    <?php } else if ($product->getSeller() === $session->getUser()->id) {
        header("Location: ../pages/myProduct.php?product={$product->id}");
    } else {
        drawProductHeader($session, $_GET['product']);
        drawProduct($session, $_GET['product']);
    }
}
  drawFooter();
?>  
