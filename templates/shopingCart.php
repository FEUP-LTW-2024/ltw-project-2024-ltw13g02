<?php
    function output_cart_items($items){ ?>
        
        <section>
            <?php
            foreach ($items as $item){
                output_single_cart_item($item);
            }?>
        </section>
    <?php 
    }
?>

<?php 
    function output_single_cart_item($item){?>
        <article class='CartItem'>
            <a href='main.html'>
                <img src="imagens/randomImage.jpg">

                <p><?=$item['prodName']?> </p>
                <p><?=$item['prodDescription']?></p>
                <p><?=$item['price']?></p>
            </a>
        </article>
    <?php }
?>