<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/../vendor/autoload.php');

?>

<?php function drawProductHeader(Session $session, $idProduct) { 
    if ($_GET['chat'] != null) { ?>
        <a href="../pages/messagesPage.php?chat=<?php echo $_GET['chat'] ?>"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
<?php }
    else { ?>
        <a href="../pages/index.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
    <?php }
} ?> 

<?php function drawProduct(Session $session, $idProduct) { 
    $product = getProduct($idProduct); 
    $photos = getPhotos($idProduct); ?>
    <div class="product-grid">
        <div class="product-image-container">
            <?php if (count($photos) == 0) { ?>
                <img class="product-image" src="../images/products/no_images_big.png" alt="Photo">
            <?php } else { ?>
                    <img src="../images/products/<?php echo $photos[0]; ?>" alt="<?php echo $photos[0]['alt']; ?>">
            <?php } ?>
        </div>
        <?php if (count($photos) != 0) { ?>
            <button class="prev-button" ><i class="fa fa-angle-left fa-2x"></i></button>
            <button class="next-button" ><i class="fa fa-angle-rigth fa-2x"></i></button>
        <?php } ?>
    </div>
<?php } ?> 