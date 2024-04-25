<?php
require_once(__DIR__ . "/../database/get_from_db.php");
    function output_archive_user_profile() { ?>
        <article id='archive page'>
            <section id='archive_header'>
                <img class="user_pfp" src="../imagens/randomImage.jpg">
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
            
            output_single_product($product);

        }
        ?>
        </section>

    </article>
    <?php }
?>


<?php
    function output_single_product($product) { 
        $session = new Session();
        $session->setId(1);
        ?>
        <article class='static_offer'>
            <div class="sliding_offer">
                <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                <div class="offer_info">
                    <h4><?= $product['prodName'] ?></h4> 
                    <h5>todo</h5> <!-- TODO change this-->
                    <p><?= $product['price'] ?>€</p>
                </div>
            </div>
        </article>
    <?php }

?>