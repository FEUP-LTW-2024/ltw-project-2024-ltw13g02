<?php
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../utils/filter.php');

function drawSearchbar(){ ?>
    <body>
        <main>
        <input id="searchbar" type="text" name="searchbar" oninput="myFunction()" placeholder="Search...">
        <div id="search-results"></div>
<?php 
}
?>

<?php  
function drawPath() { 
    $category = $_GET["category"];
    if ($category != null) $types = getTypesofCategory($category);
    else $categories = getCategories();
    $conditions = getConditions();
?>
<form id="filter" action="../pages/index.php" method="get">
    <?php if ($category == NULL) { ?>
        <select name="category" id="category">
            <option value="">Category</option> 
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
    <?php }  else { 
        ?> <input type="hidden" name="category" value="<?php echo $category; ?>"> <?php
            for ($i = 0; $i < count($types); $i++) {
                $characteristics = getCharacteristicsofType($types[$i]['idType']); ?>
                <select name="characteristic<?php echo $i + 1 ?>" class="characteristic">
                    <?php 
                    echo $_GET["characteristic" . $i + 1] != NULL ? "<option value='" . $_GET["characteristic" . $i + 1] . "'>" . getCharacteristic($_GET["characteristic" . $i + 1]) . "</option> <option value=''>" . $types[$i]['type_name'] . "</option> " : "<option value=''>" . $types[$i]['type_name'] . "</option> ";
                    foreach($characteristics as $c) { 
                        if ($_GET["characteristic" . $i + 1] != NULL && $c['characteristic'] == getCharacteristic($_GET["characteristic" . $i + 1])) {
                            continue;
                        }
                        else { ?>
                        <option value="<?= $c['idCharacteristic'] ?>"> 
                            <?= $c['characteristic'] ?>
                        </option>    
                    <?php }
                    } ?>
                </select>
        <?php }
        } ?>
    <select name="condition" id="condition">
        <?php 
            echo $_GET["condition"] != NULL ? "<option value='" . $_GET["condition"] . "'>" . getCondition($_GET["condition"]) . "</option> <option value=''>Condition</option>" : "<option value=''>Condition</option>";
            foreach($conditions as $c) { 
                if ($_GET["condition"] != NULL && $c['condition'] == getCondition($_GET["condition"])) {
                    continue;
                }
                else {
        ?>
                <option value="<?= $c['idCondition'] ?>"> 
                    <?= $c['condition'] ?>
                </option>    
        <?php 
                }
            }
        ?>
    </select>
    <input type="text" class="price-filter" name="price-min" placeholder=" Min Price" value="<?= $_GET["price-min"] === NULL ? "" : $_GET["price-min"] ?>">
    <input type="text" class="price-filter" name="price-max" placeholder=" Max Price" value="<?= $_GET["price-max"] === NULL ? "" : $_GET["price-max"] ?>">
    <button id="go-search" class="button" type="submit">Search</button>
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
                            drawSmallProduct($product, $seller, null);  ?>
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
                        drawSmallProduct($product, $seller, null);  ?>
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
                        drawSmallProduct($product, $seller, null);  ?>
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
                    drawSmallProduct($product, $seller, null);  ?>
                </div> <?php
            }
            ?>
        </div>
    </section>
<?php }
?>

<?php
function drawAnnouncements($announcements_ids, $user)
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
                        drawSmallProduct($product, $seller, $user);  ?>
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
                        drawSmallProduct($product, $seller, null);  ?>
                    </div> <?php 
                } ?>
            </div>
        </section>
    <?php } 
?>
<?php function drawProductswithFilter() { 
    if ($_GET['characteristic1'] != NULL) {
        $products = getProductsWithCh($_GET['characteristic1']);
        if ($_GET['characteristic2'] != NULL) $products = array_merge($products, getProductsWithCh($_GET['characteristic2']));
        if ($_GET['characteristic3'] != NULL) $products = array_merge($products, getProductsWithCh($_GET['characteristic3']));
    }
    else if ($_GET['category'] != NULL)  $products = getProductWithCategory($_GET['category']); 
    else $products = getRecommended(); 
    if ($_GET['condition'] != NULL) $products = filterByCondition($products, $_GET['condition']);
    if ($_GET['price-min'] != NULL || $_GET['price-max'] != NULL) $products = filterByPrice($products, $_GET['price-min'], $_GET['price-max']);?>
    <section class="Products" id="ProductsWithFilter">
        <div id="static_offer_container">
            <?php
            foreach($products as $id) {
                $product = getProduct($id);

                $seller = $product->getSeller();?>
                <div class="static_offer"> <?php
                    drawSmallProduct($product, $seller, null);  ?>
                </div> <?php
            } ?>
        </div>
    </section>
<?php } ?>

<?php
function drawSmallProduct(Product $product, $seller, $user) { ?>
    <a href="../pages/seller_page.php?user=<?=$seller->id?>" class="user_small_card">
        <?php if ($seller->photo != "Sem FF") { ?>
            <img class="user_small_pfp" src="../images/userProfile/<?=$seller->photo?>"> 
        <?php } else { ?>
            <h2><i class="fa fa-user fa-1x user-icons"></i></h2>
        <?php } ?>
        <p><?=$seller->name() ?></p>
    </a>
    <?php if ($user == null){ ?>
        <a href="../pages/productPage.php?product=<?=$product->id?>"><img class="offer_img" src="../images/products/<?= $product->getPhotos()[0]['photo']?>"></a>
    
        <a class="offer_info" href="../pages/productPage.php?product=<?=$product->id?>">
            <h4><?=substr($product->name, 0, 30) ?></h4>
            <h5><?= $seller->city . ", " . $seller->getCountry()?></h5>
            <p><?=$product->price?>€</p>
        </a>
    <?php } else { ?>
        <a href="../pages/myProduct.php?product=<?=$product->id?>"><img class="offer_img" src="../images/products/<?= $product->getPhotos()[0]['photo']?>"></a>
    
        <a class="offer_info" href="../pages/myProduct.php?product=<?=$product->id?>">
            <h4><?=substr($product->name, 0, 30) ?></h4>
            <h5><?= $seller->city . ", " . $seller->getCountry()?></h5>
            <p><?=$product->price?>€</p>
        </a>
    <?php } ?>
    
<?php } ?>