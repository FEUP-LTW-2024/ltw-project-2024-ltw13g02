<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/../database/change_in_db.php');


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
    $seller = getSeller($idProduct); 
    $photos = getPhotos($idProduct); ?>
    <div class="product-grid">
        <div class="product-image-container">
            <?php if (count($photos) == 0) { ?>
                <img id="product-image" src="../images/products/no_images_big.png" alt="Photo">
            <?php } else { ?>
                <img id="product-image" src="../images/products/<?php echo $photos[0]['photo']; ?>" alt="photo">
            <?php } ?>
        </div>
        <?php if (count($photos) > 1) { ?>
            <button class="prev-button" onclick="changePhoto(-1)"><i class="fa fa-angle-left fa-2x prev-icon"></i></button>
            <button class="next-button" onclick="changePhoto(1)"><i class="fa fa-angle-right fa-2x next-icon"></i></button>
        <?php } ?>

        <div class="product-info">
            <h2 id="product-page-name">Name: <?php echo $product['prodName'] ?> </h2>
            <h2 id="product-page-price">Name: <?php echo $product['price'] ?> </h2>
            <h2 id="product-page-name">Seller: <?php echo $seller['prodName'] ?> </h2>
            <h2 id="stars">
                <?php
                $stars = $session->getStars();
                drawStars($stars);
                ?>
            </h2>
            <h2 id="product-page-description">Description: <?php echo $seller['prodDescription'] ?> </h2>
        </div>
    </div>

    <script>
        var currentIndex = 0;
        var photos = <?php echo json_encode($photos); ?>;

        function changePhoto(delta) {
            currentIndex += delta;
            if (currentIndex < 0) {
                currentIndex = photos.length - 1;
            } else if (currentIndex >= photos.length) {
                currentIndex = 0;
            }
            document.getElementById('product-image').src = "../images/products/" + photos[currentIndex]['photo'];
        }
    </script>
<?php } ?> 