<?php
require_once(__DIR__ . '/../database/get_from_db.php');

    function drawSearchbar($categories){ ?>
        <body>
            <main>
            <form id="search">
            <select name="category">
            <option value="All">All</option> 

                <?php 
                    foreach($categories as $category){ ?>
                        <option value="<?= $category['category'] ?>"> 
                            <?= $category['category'] ?>
                        </option>    
                    <?php 
                    }
                ?>
            </select>
            <input type="search" name="searchbar" required>
        </form> 
    <?php 
    }
?>

<?php
function drawRecent($recent_ids)
    { ?>
        <section class="Products" id="Recent">
            <h2>Recents</h2>
            <article>
                <div class="sliding_offers_container"> <?php 
                    foreach($recent_ids as $item_id)
                    {
                        $product = getProduct($item_id);

                        $seller = $product->getSeller();
                        ?>
                        <div class="sliding_offer"> <?php
                            drawProduct($product, $seller);  ?>
                        </div> <?php 
                    } ?>
                </div>
                <button class="move_button">&#60</button>
                <button class="move_button">></button>
            </article>
        </section>
    <?php } 
?>

<?php 

function drawFavorites($favorites_ids){ ?>
    <section class="Products" id="Favorites">
        <h2>Favorites</h2>
        <article>
            <div class="sliding_offers_container"> <?php 
                foreach($favorites_ids as $item_id)
                {
                    $product = getProduct($item_id);

                    $seller = $product->getSeller();
                    ?>
                    <div class="sliding_offer"> <?php
                        drawProduct($product, $seller);  ?>
                    </div> <?php 
                } ?>
            </div>
            <button class="move_button">&#60</button>
            <button class="move_button">></button>
        </article>
    </section>
 
<?php }
?>

<?php
function drawRecommended($recommended_ids) { ?>
    <section class="Products" id="Recommended">
        <h2>Recommended</h2>
        <div id="static_offer_container">
            <?php
            for ($i = 0; $i < 20; $i++)
            {
                if(isset($recommended_ids[$i])){
                    $item_id = $recommended_ids[$i];
                    $product = getProduct($item_id);

                    $seller = $product->getSeller();?>
                    <div class="static_offer"> <?php
                        drawProduct($product, $seller);  ?>
                    </div> <?php
                }
            } ?>
        </div>
    </section>
<?php }
?>

<?php
function drawSellerProducts($seller_items_ids) { ?>
    <section class="Products" id="SellerProducts">
        <h2>Seller Products</h2>
        <div id="static_offer_container">
            <?php
            $firstProduct = getProduct($seller_items_ids[0]);
            $seller = $firstProduct->getSeller();
            foreach($seller_items_ids as $itemId)
            { 
                $product = getProduct($itemId) ?>   
                <div class="static_offer"> <?php
                    drawProduct($product, $seller);  ?>
                </div> <?php
            }
            ?>
        </div>
    </section>
<?php }
?>

<?php
function drawAnnouncements($announcements_ids)
    { ?>
        <section class="Products" id="Announcements">
            <h2>My Announcements</h2>
            <article>
                <div class="sliding_offers_container"> <?php 
                    foreach($announcements_ids as $item_id)
                    {
                        $product = getProduct($item_id);

                        $seller = $product->getSeller();
                        ?>
                        <div class="sliding_offer"> <?php
                            drawProduct($product, $seller);  ?>
                        </div> <?php 
                    } ?>
                </div>
            </article>
        </section>
    <?php } 
?>


<?php
function drawProduct(Product $product, $user){ ?>
        <a href="../pages/seller_page.php?user=<?=$user->getId()?>" class="user_small_card">
            <?php if ($user->getPhoto() != "Sem FF") { ?>
                <img class="user_small_pfp" src="../images/userProfile/<?=$user->getPhoto()?>"> 
            <?php } else { ?>
               <h2><i class="fa fa-user fa-1x user-icons"></i></h2>
            <?php } ?>
            <p><?=$user->name() ?></p>
        </a>
        <a href="../pages/productPage.php?product=<?=$product->getId()?>"><img class="offer_img" src="../images/products/<?= $product->getPhotos()[0]['photo']?>"></a>

        <a class="offer_info" href="../pages/productPage.php?product=<?=$product->getId()?>">
            <h4><?=substr($product->getName(),0,30) ?></h4>
            <h5><?= $user->getCity() . ", " . $user->getCountry()?></h5>
            <p><?=$product->getPrice()?>€</p>
        </a>
<?php 
} 
?>