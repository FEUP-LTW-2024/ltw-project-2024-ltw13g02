<?php
    function output_cart_items($items){ ?>
        
        <section id='Shopping_Cart'>
            <h2>Shopping Cart</h2>
            <section id='Shopping_items'>
                <?php
                foreach ($items as $item){
                    output_single_cart_item($item);
                }
                output_total_payment($items);
            ?>
            </section>
    <?php 
    }
?>

<?php 
    function output_single_cart_item($item){?>
        <article class='CartItem'>
            <a href='main.html'>
                <img src="<?= $item['prodName'] ?>">
                <p id='cart_item_name'><?=$item['prodName']?> </p>
                <p id='cart_item_price'><?=$item['price']?>€</p>
            </a>
        </article>
    <?php }
?>

<?php
    function output_total_payment($items){
        $total = 0;
        foreach ($items as $item){
            $total += $item['price'];
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
    function output_shipping_address( $address, $countries){ ?>
        <aside>
            <h3>Checkout</h3> 
        <form id ='address' action="cart.php" method="post">

                <h5>Address</h5>
                <p><?= $address['userAddress']?> </p>
                <p><?= $address['zipCode']?>, <?= $address['city']?></p>
                <p><?= $address['country']?></p>
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