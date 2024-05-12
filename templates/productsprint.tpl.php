<?php
require_once(__DIR__ . '/../database/get_from_db.php');

function drawSearchbar(){ ?>
    <body>
        <script src="../javascript/search.js" defer></script>
        <main>
        <form id="search">
            <button id="searchButton"><i class="fa fa-search fa-1x icon"></i></button>
            <input id="searchbar" type="search" name="searchbar" placeholder="Search..." required>
        </form> 
<?php 
}
?>

<?php  
function drawPath($category, $type, $characteristic) { 
    if ($characteristic == NULL) {
        if ($type != null) $characteristics = getCharacteristicsofType($type);
        else if ($category != null) $types = getTypesofCategory($category);
        else if ($category == null) $categories = getCategories();
    } 
?>
<form id="filter" action="../pages/index.php" method="get">
    <input type="hidden" name="category" value="<?php echo $category; ?>">
    <input type="hidden" name="type" value="<?php echo $type; ?>">
    <?php if ($category == NULL) { ?>
        <select name="category">
            <option value="All">All</option> 
            <?php 
                foreach($categories as $c){ 
            ?>
                    <option value="<?= $c['idCategory'] ?>"> 
                        <?= $c['category'] ?>
                    </option>    
            <?php 
                }
            ?>
        </select>
        <button id="go-search" class="button" type="submit">Search</button>
    <?php }  else { 
        if ($type == NULL) { ?>
            <h2 class="path"><?php echo getCategory($category) . " |" ?></h2>
            <select name="type">
                <option value="All">All</option> 
                <?php 
                    foreach($types as $t){ 
                ?>
                        <option value="<?= $t['idType'] ?>"> 
                            <?= $t['type_name'] ?>
                        </option>    
                <?php 
                    }
                ?>
            </select>
            <button id="go-search" class="button" type="submit">Search</button>
        <?php } else { ?>
            <?php if ($characteristic == NULL) {?>
                <h2 class="path"><?php echo getCategory($category) . " | " . getTypebyId($type) . " |" ?></h2>
                <select name="characteristic">
                    <option value="All">All</option> 
                    <?php 
                        foreach($characteristics as $ch){ 
                    ?>
                            <option value="<?= $ch['idCharacteristic'] ?>"> 
                                <?= $ch['characteristic'] ?>
                            </option>    
                    <?php 
                        }
                    ?>
                </select>
                <button id="go-search" class="button" type="submit">Search</button>
            <?php } else {?>
                <h2 class="path"><?php echo getCategory($category) . " | " . getTypebyId($type) . " | " . getCharacteristic($characteristic) ?></h2>
            <?php } ?>
        <?php } ?>
    <?php }?>
</form>
<?php } ?>




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
            </article>
        </section>
    <?php } 
?>

<?php 

function drawFavorites($favorites_ids){ ?>
    <section class="Products" id="Favorites">
        <h2>Favorites</h2>
            <div id="static_offer_container"> <?php 
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
    </section>
<?php 
}
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
            <div id="static_offer_container"> <?php 
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
        </section>
    <?php } 
?>

<?php
function drawArchive($archive_ids)
    { ?>
        <section class="Products" id="Archive">
            <h2>My Archive</h2>
            <div id="static_offer_container"> <?php 
                foreach($archive_ids as $item_id)
                {
                    $product = getProduct($item_id);

                    $seller = $product->getSeller();
                    ?>
                    <div class="sliding_offer"> <?php
                        drawProduct($product, $seller);  ?>
                    </div> <?php 
                } ?>
            </div>
        </section>
    <?php } 
?>

<?php function drawProductswithFilter($category, $type, $characteristic) { 
    if ($characteristic != NULL) $products = getProductsWithCh($characteristic);
    else if ($type != NULL)  $products = getProductsWithType($type);
    else if ($category != NULL)  $products = getProductWithCategory($category); ?>
    <section class="Products" id="ProductsWithFilter">
        <div id="static_offer_container">
            <?php
            foreach($products as $id) {
                $product = getProduct($id);

                $seller = $product->getSeller();?>
                <div class="static_offer"> <?php
                    drawProduct($product, $seller);  ?>
                </div> <?php
            } ?>
        </div>
    </section>
<?php } ?>

<?php
function drawProduct(Product $product, $user){ ?>
        <a href="../pages/seller_page.php?user=<?=$user->id?>" class="user_small_card">
            <?php if ($user->photo != "Sem FF") { ?>
                <img class="user_small_pfp" src="../images/userProfile/<?=$user->photo?>"> 
            <?php } else { ?>
               <h2><i class="fa fa-user fa-1x user-icons"></i></h2>
            <?php } ?>
            <p><?=$user->name() ?></p>
        </a>
        <a href="../pages/productPage.php?product=<?=$product->id?>"><img class="offer_img" src="../images/products/<?= $product->getPhotos()[0]['photo']?>"></a>

        <a class="offer_info" href="../pages/productPage.php?product=<?=$product->id?>">
            <h4><?=substr($product->name,0,30) ?></h4>
            <h5><?= $user->city . ", " . $user->getCountry()?></h5>
            <p><?=$product->price?>€</p>
        </a>
<?php 
} 
?>