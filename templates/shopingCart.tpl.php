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
                output_payment($items_ids);
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
    function output_payment($items){
        $order = 0;
        foreach ($items as $item){
                $product = getProduct($item);
                $order += $product->price;
        } ?>
        <article id="totalPay" class="totalPayment">
            <p>Total:</p>
            <p><?= $order ?>€</p>
        </article>
    <?php
    }
?>

<?php
    function output_shipping_address(Session $session,$countries){ 
        $user = $session->getUser(); ?>
        <script src="../javascript/paymentMethod.js" defer></script>
        <aside id="shippingAdress">
            <h3>Checkout</h3> 
            <form id ='addressShipping' action="../actions/process_purchase.php" method="post">
                <div>Street:</div><input type='text' id="addressField" name='address' required="required" value= "<?=$session->getUser()->userAddress?>">
                <div>City:</div> <input type='text' id="cityField" name='city' required="required" value= "<?= $session->getUser()->city?>">
                <div>Zipcode:</div> <input type='text' id="zipcodeField" name='zipcode' required="required" value= "<?= $session->getUser()->zipCode?>">
                <input type="hidden" name='csrf' value="<?=$session->getCSRF()?>">
                <?php
                output_country_option($countries);
                ?>
                <h5 id="please-select">Please select your payment method:</h5> <br>
                <div class="radio-group">
                    <div class="radio-item">
                        <input type="radio" name="method" value="mbway" onclick="clicked()" checked>
                        <label for="mbway">MBway</label>
                        <div id="mbway-form" class="info-payment">
                            <label for="phone" class="label-pay">Phone:</label>
                            <input type="text" id="phone" class="input-pay" name="phone" value="<?= $user->phone; ?>">
                        </div>
                    </div>
                    <div class="radio-item" >
                        <input type="radio" name="method" onclick="clicked()" value="paypal">
                        <label for="paypal">PayPal</label>
                        <div id="paypal-form" class="info-payment hidden">
                            <label id="email" class="label-pay" required>Email</label>
                            <input type="text" id="email" class="input-pay" name="email" value="<?= $user->email; ?>">
                        </div>
                    </div>
                    <div class="radio-item">
                        <input type="radio" name="method" onclick="clicked()" value="mb">
                        <label for="mb">MB</label>
                        <div id="mb-form" class="info-payment hidden">
                            <div>Entity: 12345</div>
                            <div id="reference">Reference: 123456789</div>
                        </div>
                    </div>
                </div> <?php 
                
                $cartCountries = getProductsCountries($session->getUser()->getShoppingCart());
                $cartCountriesJson = json_encode($cartCountries); 
                $total = getProductsPrice($session->getUser()->getShoppingCart());
                ?>
                
                <button id = "formSubmitButton" class="submitButton" type="button" onclick="submitClick(<?= htmlspecialchars($cartCountriesJson) ?>,<?=htmlspecialchars($total)?>)" value="Pay Now">Pay Now</button>
                <div id="confirmationModal" class="modal hidden">
                    <div class="modal-content">
                        <p>Do you want to proceed to checkout?</p>
                        <button id="confirmYes" type="submit" class="submitButton">Yes</button>
                        <button id="confirmNo" type="button" class="submitButton">No</button>
                    </div>
                </div>
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
            <select name='country' onclick>
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

<?php
    function getProductsCountries(array $productsIds) : array {
        $countries = array();
        $i = 0;
        foreach ($productsIds as $productId) {
            $product = getProduct($productId);
            $countries[$i] = $product->getSeller()->getCountry();
            $i += 1;
        }
        return $countries;
    }
?>

<?php
    function getProductsPrice(array $productsIds) : int {
        $price = 0;
        foreach ($productsIds as $productId) {
            $product = getProduct($productId);
            $price += $product->price;
        }
        return $price;
    }

?>