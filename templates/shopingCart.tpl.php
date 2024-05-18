<?php
    require_once(__DIR__ . '/../database/get_from_db.php');

    function output_empty_cart() { ?>
        <main id='EMPTY_Shopping_Cart'>
            <img class="empty_cart_img" src="../images/empty_cart.png">
            <h2>Your Shopping Cart is empty</h2>
        </main>
    <?php }
?>


<?php
    function output_cart_items($items_ids){?>
        
        <main id='Shopping_Cart'>
            <h2>Shopping Cart</h2>
            <section id='Shopping_items'>
                <?php
                foreach ($items_ids as $item){
                    $product = getProduct($item);
                    output_single_cart_item($product);
                }
                output_total_payment($items_ids);
            ?>
            </section>
    <?php 
    }
?>

<?php 
    function output_single_cart_item(Product $item){
        $photos = $item->getPhotos();

        $session = new Session();

        ?>
        
            <article class='CartItem'>
                <a class="product_img" href="../pages/productPage.php?product=<?=$item->id?>">
                    <img src="../images/products/<?= $photos[0]['photo'] ?>">
                </a>
                <p id='cart_item_name'> <a href="../pages/productPage.php?product=<?=$item->id?>">  <?=$item->name?> </a> </p>
                <p id='cart_item_price'><a href="../pages/productPage.php?product=<?=$item->id?>"> <?=$item->price?>€ </a> </p>
                <form action="../actions/removeFromCart.php" method="post">
                    <input type="hidden" name="product" value=<?=$item->id?>> </input>
                    <input type="hidden" name="user" value="<?=$session->getUser()->id?>"> </input>
                    <button type="submit" id="trashIcon">
                        <i class="fa fa-trash-o"> </i>
                    </button>
                </form>
            </article>
    <?php }
?>

<?php
    function output_total_payment($items){
        $total = 0;
        foreach ($items as $item){
                $product = getProduct($item);
                $total += $product->price;
            }  
        ?>
        <article id="totalPayment">
            <p>Total:</p>
            <p><?= $total ?>€</p>
        </article>
    <?php
    }
?>

<?php
    function output_shipping_address(Session $session,$countries){ ?>
        <aside id="shippingAdress">
            <h3>Checkout</h3> 
            <h5>Address</h5>
            <form id ='addressShipping' action="../actions/process_purchase.php" method="post">
                <div>Street:</div> <input type='text' id="addressField" name='address' required="required" value= "<?=$session->getUser()->userAddress?>">
                <div>City:</div> <input type='text' id="cityField" name='city' required="required" value= "<?= $session->getUser()->city?>">
                <div>Zipcode:</div> <input type='text' id="zipcodeField" name='zipcode' required="required" value= "<?= $session->getUser()->zipCode?>">
                <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                <?php
                output_country_option($countries);
                ?>
                <div>Please select your payment method:</div> <br>
                    <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" id="paypal" name="method" value="paypal" checked>
                        <label for="paypal">PayPal</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" id="mbway" name="method" value="mbway">
                        <label for="mbway">MBway</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" id="mb" name="method" value="mb">
                        <label for="mb">MB</label>
                    </div>
                </div>

                <input id = "formSubmitButton" type="submit" value="Pay Now">
            </form>
        </aside>
        </main>
    <?php }
?>

<?php
    function output_country_option($countries){ 
        $session = new Session();
        ?>
        
        <div class='address_field' id ='countryField'>
        Country:
        </div>
            <select name='country'>
                <?php 
                    foreach ($countries as $country){ 
                        $user = $session->getUser();
                        if ($country['country'] === $user->getCountry())
                        { ?>
                            <option value="<?=$country['country']?>" selected><?=$country['country']?></option>
                        <?php 
                        }else{ ?>
                            <option value="<?=$country['country']?>"><?=$country['country']?></option>
                        <?php }
                        }
                ?>
            </select>


    <?php }
?>