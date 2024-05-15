<?php
require_once(__DIR__ . "/../database/get_from_db.php");
require_once(__DIR__ . "/../database/user.class.php");

    function output_archive_user_profile(Session $session) { ?>
        <main id='archive page'>
            <section id='archive_header'>
                <img class="user_pfp" src="/../images/userProfile/<?=$session->getUser()->photo?>">
                <h4>Archive</h4>
                <p>(Sold Items)</p>
            </section>
    <?php }
    
?>


<?php

    function output_archive_user_products($products) { ?>
        <section class="Products" id='archive_products'>
            <div id="static_offer_container"> <?php
            foreach ($products as $product) {
                $archived_product = getProduct($product);
                $buyer = getUserbyId($archived_product->buyer);
                output_single_product($archived_product,$buyer);
            }  ?>
            </div>
        </section>

    </main>
    <?php }
?>


<?php
    function output_single_product(Product $product, User $buyer) { 
        ?>
        <article class='static_offer'>
                <a href="main.html" class="user_small_card">
                    <img class="user_small_pfp" src="images/<?= $buyer->photo?>">
                    <p><?=$buyer->name()?></p>
                </a>
                <a href="main.html"><img class="offer_img" src="images/randomImage.jpg"></a>
                <!-- TODO mudar href para product page com id do prod -->

                <div class="offer_info">
                    <h4><?= $product->name ?></h4> 
                    <h5>Sold to: <?= $buyer->name() ?></h5> <!-- TODO change this-->
                    <h6>Price:<?= $product->price ?>€</h6>
                </div>
        </article>
    <?php }

?>