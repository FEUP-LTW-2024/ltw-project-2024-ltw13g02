<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/product.class.php');
require_once(__DIR__ . '/../database/chat.class.php');
require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/user.tpl.php');


?>

<?php function drawProductHeader(Session $session, $idProduct) { 
    if ($_GET['chat'] != null) { 
        $chat = getChat($_GET['chat']);
        if ($chat->getInfo()['idProduct'] === $idProduct) { ?>
            <a href="../pages/messagesPage.php?chat=<?php echo $_GET['chat'] ?>"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
<?php   }
        else { ?>
            <a href="../pages/index.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
        <?php }
    }
    else { ?>
        <a href="../pages/index.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
    <?php }
} ?> 

<?php function drawProduct(Session $session, $idProduct) { 
    $user = $session->getUser();
    $product = getProduct($idProduct);
    if ($user != null && $product->getSeller()->getId() != $user->getId()) {
        $user->addToRecents($idProduct);
    }
    
    $seller = $product->getSeller(); 
    $photos = $product->getPhotos(); ?>
    <div class="product-grid" id="product-grid">
        <div class="product-image-container">
            <?php if (count($photos) === 0) { ?>
                <img id="product-image" src="../images/products/no_images_big.png" alt="Photo">
            <?php } else { ?>
                <img id="product-image" src="../images/products/<?php echo $photos[0]['photo']; ?>" alt="photo">
            <?php } ?>
            <?php if (count($photos) > 1) { ?>
                <button class="prev-button" onclick="changePhoto(-1)"><i class="fa fa-angle-left fa-2x prev-icon"></i></button>
                <button class="next-button" onclick="changePhoto(1)"><i class="fa fa-angle-right fa-2x next-icon"></i></button>
            <?php } ?>
        </div>

        <div class="product-info">
            <h2 id="product-page-name"><?php echo $product->getName(); ?> </h2>
            <h2 id="product-page-price"><?php echo $product->getPrice(); ?> € </h2>
            <a href="" class="product-page-seller"><h2 class="product-page-seller"><?php echo $seller->name(); ?> </h2></a>
            <a href="" class="product-page-stars"><h2 class="product-page-stars stars">
                <?php
                $stars = $seller->getStarsFromReviews();
                drawStars($stars);
                ?>
            </h2></a>
            <?php
            $characteristics = $product->getCharacteristics();
            $category = $product->getCategory();
            ?>
            <a href="" class="product-category"><h2 class="product-category">Category: <?php echo $category ?> </h2></a>
            <div id="product-characteristics"> 
                <?php foreach ($characteristics as $c) { ?> 
                    <a href="" class="product-characteristic"><h2 id="product-characteristic"> <?php echo $c ?> </h2></a>
                <?php } ?>
            </div>
            <h2 id="product-page-description">Description: <?php echo $product->getDescription(); ?> </h2>
            <?php $user = $session->getUser();
            if($user != null){
                $chat = $user->findBuyerChat($idProduct);
                $idChat = $chat->getId(); 
                if($seller->getId() != $user->getId()){?>
                    <button id="contact" class="button"><a href="../pages/messagesPage.php?chat=<?php echo $idChat ?>">Contact me</a></button>
                    <?php
                        $favorites = $user->getFavorites();
                        if($favorites != null && in_array($idProduct, $favorites)) { ?>
                            <a href="../actions/updateFavorites.php?product=<?=$product->getId()?>" id="a_favs"><i class="fa fa-heart isFav fa-2x icon" id="favs"></i></a> <?php
                        } else { ?>
                            <a href="../actions/updateFavorites.php?product=<?=$product->getId()?>" id="a_favs"><i class="fa fa-heart-o fa-2x icon" id="favs"></i></a> <?php
                        }
                        $shoppingCart = $user->getShoppingCart();
                        if(in_array($idProduct, $shoppingCart))
                        { ?>
                            <button id="remove-from-cart" class="button"><a href="../actions/updateCart.php?product=<?=$product->getId()?>">Take From Cart</a></button> <?php
                        } else{ ?>
                            <button id="add-to-cart" class="button"><a href="../actions/updateCart.php?product=<?=$product->getId()?>">Add to cart</a></button> <?php
                        }
                    ?>
                <?php } 
            }?>
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