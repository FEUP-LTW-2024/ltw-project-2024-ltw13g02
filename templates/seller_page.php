<?php
    function output_seller_header($db, $user) { 
        $num_reviews = get_user_num_reviews($db, $user['idUser']);
        ?>
        <article id="seller_header">
            <p id='user_fullname'><?= $user['firstName']?> <?= $user['lastName']?></p>
            <div id='user_reviews_info'>
                <a href="main.html">
                <?php
                    for ($i = 0; $i < $user['stars']; $i++) { ?>
                    <img class="userStartImg" src="imagens/logo.png" alt="seller star">
                </a>
                <?php }
            ?>
            <p id='average_of_reviews'><?= $user['stars']?></p>    
            <p id='number_of_reviews'><?= $num_reviews?> reviews</p>    
            </div>
            <img class="userStartImg" src="imagens/logo.png" alt="seller profile">
        </article> 
    <?php }
?>