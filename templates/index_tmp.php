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
function drawRecent($recent_ids, $db)
    { ?>
        <section class="Products" id="Recent">
            <h2>Recents</h2>
            <article>
                <div class="offers_container"> <?php 
                    foreach($recent_ids as $item_id)
                    {
                        $product = build_Product_from_id($db, $item_id);

                        $user = getUserInfo($db,$product->seller);
                        drawProduct($product, $user);  
                    } ?>
                </div>
                <button class="move_button">&#60</button>
                <button class="move_button">></button>
            </article>
        </section>
    <?php } 
?>

<?php 

function drawFavorites($favorites_ids, $db){ ?>
    <section class="Products" id="Favorites">
        <h2>Recents</h2>
        <article>
            <div class="offers_container"> <?php 
                foreach($favorites_ids as $item_id)
                {
                    $product = build_Product_from_id($db, $item_id);

                    $user = getUserInfo($db,$product->seller);
                    drawProduct($product, $user);  
                } ?>
            </div>
            <button class="move_button">&#60</button>
            <button class="move_button">></button>
        </article>
    </section>
 
<?php }
?>

<?php
function drawProduct($product, $user){ ?>
    <div class="sliding_offer">
        <a href="../pages/seller_page.php?user=<?=$user->idUser?>" class="user_small_card">
            <img class="user_small_pfp" src="../images/userProfile/<?=$user->photo?>"> 
            <p><?=$user->name() ?></p>
        </a>
        <a href="../pages/productPage.php?product=<?=$product->idProduct?>"><img class="offer_img" src="../images/randomImage.jpg"></a> <!--TODO adicionar imagem do prod-->

        <a class="offer_info" href="../pages/productPage.php?product=<?=$product->idProduct?>">
            <h4><?=substr($product->prodName,0,30) ?></h4>
            <h5><?= $user->city . ", " . getCountryFromDB($user->idCountry)?></h5>
            <p><?=$product->price?>€</p>
        </a>
    </div>
<?php 
} 
?>

<?php
function drawRecommended($db, $recommended_ids) { ?>
    <section class="Products" id="Recommended">
        <h2>Recommended</h2>
        <article>
            <div class="offers_container"> <?php 
                foreach($recommended_ids as $item_id)
                {   
                    var_dump($item_id);
                    $product = build_Product_from_id($db, $item_id);

                    $user = getUserInfo($db,$product->seller);
                    drawProduct($product, $user);  
                } ?>
            </div>
            <button class="move_button">&#60</button>
            <button class="move_button">></button>
        </article>
    </section>
<?php }

?>