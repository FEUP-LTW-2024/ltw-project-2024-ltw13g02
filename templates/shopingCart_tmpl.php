<?php
    function output_empty_cart() { ?>
        <section id='Shopping_Cart'>
            <img class="empty_cart_img" src="../images/empty_cart.png">
            <h2>Your Shopping Cart is empty</h2>
        </section>
    <?php }
?>


<?php
    function output_cart_items($items_ids){ 
        $db = getDatabaseConnection();  
        ?>
        
        <section id='Shopping_Cart'>
            <h2>Shopping Cart</h2>
            <section id='Shopping_items'>
                <?php
                foreach ($items_ids as $item){
                    $product = build_Product_from_id($db, $item['product']);
                    output_single_cart_item($product);
                }
                output_total_payment($items_ids);
            ?>
            </section>
    <?php 
    }
?>

<?php 
    function output_single_cart_item(Product $item){?>
        <article class='CartItem'>
            <a href='../pages/index.php'> <!--TODO change to product page -->
                <img src="../images/randomImage.jpg"> <!-- TODO add photo -->
                <p id='cart_item_name'><?=$item->prodName ?> </p>
                <p id='cart_item_price'><?=$item->price ?>€</p>
            </a>
        </article>
    <?php }
?>

<?php
    function output_total_payment($items){
        $db = getDatabaseConnection();
        $total = 0;
        foreach ($items as $item){
                $product = build_Product_from_id($db, $item['product']);
                $total += $product->price;
            }  
        ?>
        <article>
            <p>Total:</p>
            <p><?= $total ?>€</p>
        </article>
    <?php
    }
?>

<?php
    function output_shipping_address(Session $session,$countries){ ?>
        <aside>
            <h3>Checkout</h3> 
        <form id ='address' action="database/process_payment.php" method="post">

                <h5>Address</h5>
                <p><?= $session->getAddress()?> </p>
                <p><?= $session->getZipCode()?>, <?= $session->getCity()?></p>
                <p><?= $session->getCountry()?></p>
                <div class='address_option' id='default_address_option'> <input type = 'radio' name='address_option' value='default_address' checked='checked'> Default Address </div>

                <div class='custom_address_field' id ='custom_address_street'>Street: <input type='text' name='custom_address'> </div>
                <div class='custom_address_field' id ='custom_address_zipcode'>Zipcode: <input type='text' name='custom_zipcode'> </div>
                <div class='custom_address_field' id ='custom_address_city'>City: <input type='text' name='custom_city'> </div> <?php
                output_country_option($countries);
                ?>


                <div class='custom_address_field' id ='custom_address_option'> <input type = 'radio' name='address_option' value='custom_address'> Custom Address </div>
                <input type="submit" value="Pay Now">
        </form>
        </aside>
        </section>
    <?php }
?>

<?php
    function output_country_option($countries){ 
        ?>
        
        <div class='custom_address_field' id ='custom_address_country'>
        Country:
            <select name='custom_country'>
                <?php 
                    foreach ($countries as $country){ ?>
                        <option value="<?=$country['country']?>"><?=$country['country']?></option>
                    <?php }
                ?>
            </select>
        </div>

    <?php }
?>