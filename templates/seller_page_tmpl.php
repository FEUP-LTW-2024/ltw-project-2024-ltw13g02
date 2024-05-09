<?php
    function output_seller_header($db, User $user) {
        $num_reviews = $user->getNumberOfReviews();
        ?>
        <article id="seller_header">
            <p id='user_fullname'><?= $user->name() ?> </p>

            <div id='user_reviews_info'>
                <a href="../pages/reviewsPage.php"> <!--TODO fix ref -->
                <span class="stars">
                    <h2 id="stars"> <?php
                    drawStars($user->getStarsFromReviews()); ?>
                    </h2> 
                </span>   
                </a>
                <?php
            ?>
            <p id='average_of_reviews'><?= $user->getStarsFromReviews()?></p>    
            <p id='number_of_reviews'><?= $num_reviews?> reviews</p>    
            </div>
            <?php
                $user_photo = $user->getPhoto(); 
                if ($user_photo !== "Sem FF") {?>
                    <img class="userStartImg" src="../images/userProfile/<?=$user->getPhoto()?>" alt="seller profile"> <?php

                }else{ ?>
                    <i class="fa fa-user fa-1x user-icons" id="seller_pfp"></i> <?php  
            }
            ?>
            
        </article> 
    <?php }
?>

<?php
    function output_seller_products($db, $products, User $user) { 

        $address = $user->getAddress();
        $city = $address['city'];
        $country = $address['country'];
        ?>
        <article id="seller_products">
            <?php
                foreach ($products as $product) { ?>
                    <a href="main.html"><img class="offer_img" src="images/randomImage.jpg"></a>
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