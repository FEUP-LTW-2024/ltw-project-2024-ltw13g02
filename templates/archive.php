<?php
require_once(__DIR__ . "/../database/get_from_db.php");
require_once(__DIR__ . "/../database/userClass.php");

    function output_archive_user_profile(Session $session) { ?>
        <article id='archive page'>
            <section id='archive_header'>
                <img class="user_pfp" src=<?= "/../imagens/userProfile/{$session->getPhotoUser()}" ?>>
                <h4>Archive</h4>
                <p>(Sold Items)</p>
            </section>
    <?php }
    
?>


<?php

    function output_archive_user_products($db, $products) { ?>
        <section id='archive_products'>
        <?php
        foreach ($products as $product) {
            $archived_product = build_Product_from_id($db,$product);
            $db = getDatabaseConnection();
            $buyer = getUserInfo($db,$product->buyer);

            output_single_product($archived_product,$buyer);
        }
        ?>
        </section>

    </article>
    <?php }
?>


<?php
    function output_single_product(Product $product, User $buyer) { 
        ?>
        <article class='static_offer'>
                <a href="main.html" class="user_small_card">
                    <img class="user_small_pfp" src="imagens/<?= $buyer->photo?>">
                    <p><?=$buyer->name()?></p>
                </a>
                <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>
                <!-- TODO mudar href para product page com id do prod -->

                <div class="offer_info">
                    <h4><?= $product->prodName ?></h4> 
                    <h5>Sold to: <?= $buyer->name() ?></h5> <!-- TODO change this-->
                    <h6>Price:<?= $product->price ?>€</h6>
                </div>
        </article>
    <?php }

?>