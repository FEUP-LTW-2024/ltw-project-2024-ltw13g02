<?php
require_once(dirname(__FILE__) . "/../templates/productsprint.tpl.php");

    function output_seller_header($db, User $user) {
        $num_reviews = $user->getNumberOfReviews();
        ?>
        <article id="seller_header">

            <div id='seller_info'>
                <p id='user_fullname'><?= $user->name() ?> </p>
                <a href="../pages/reviewsPage.php?user=<?=$user->id?>">
                    <span class="stars">
                        <h2 id="stars"> <?php
                            drawStars($user->getStarsFromReviews()); ?>
                        </h2>
                        <p id='average_of_reviews'><?= round($user->getStarsFromReviews() ,precision:1, mode:PHP_ROUND_HALF_UP)?></p>  
                    </span>
                    <p id='number_of_reviews'><?= $num_reviews?> reviews</p>    
                </a>
                <?php
            ?>
            </div>
            <?php
                $user_photo = $user->photo; 
                if ($user_photo !== "Sem FF") {?>
                    <img class="userStartImg" id="seller_pfp" src="../images/userProfile/<?=$user->photo?>" alt="seller profile"> <?php

                }else{ ?>
                    <i class="fa fa-user fa-1x user-icons" id="seller_pfp"></i> <?php  
            }
            ?>
            
        </article> 
    <?php }
?>