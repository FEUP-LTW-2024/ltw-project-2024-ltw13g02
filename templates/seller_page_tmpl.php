<?php
    function output_seller_header($db, User $user) {
        $num_reviews = get_user_num_reviews($db, $user->idUser);
        ?>
        <article id="seller_header">
            <p id='user_fullname'><?= $user->name() ?> </p>

            <div id='user_reviews_info'>
                <a href="main.html">
                <?php
                    for ($i = 0; $i < $user->stars ; $i++) { ?>
                    <img class="userStartImg" src="imagens/logo.png" alt="seller star">
                </a>
                <?php }
            ?>
            <p id='average_of_reviews'><?= $user->stars?></p>    
            <p id='number_of_reviews'><?= $num_reviews?> reviews</p>    
            </div>
            <img class="userStartImg" src="imagens/logo.png" alt="seller profile">
            
        </article> 
    <?php }
?>

<?php
    function output_seller_products($db, $products, User $user) { 

        $address =getUserAddress($db,$user);
        $city = $address['city'];
        $country = $address['country'];
        ?>
        <article id="seller_products">
            <?php
                foreach ($products as $product) { ?>
                    <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>
                    <div class="offer_info">
                            <h4> <?= $product['prodName'] ?> </h4>
                            <h5><? $city . ', ' . $country ?></h5>
                            <p><?= $product['price'] ?></p>
                        </div>
                <?php }
            ?>
        </article>
    <?php }
?>