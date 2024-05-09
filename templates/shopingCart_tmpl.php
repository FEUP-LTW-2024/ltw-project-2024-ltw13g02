<?php
    require_once(__DIR__ . '/../database/get_from_db.php');

    function output_empty_cart() { ?>
        <main id='Shopping_Cart'>
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
                <a id="product_img" href="../pages/productPage.php?product=<?=$item->getId()?>">
                    <img src="../images/products/<?= $photos[0]['photo'] ?>">
                </a>
                <p id='cart_item_name'> <a href="../pages/productPage.php?product=<?=$item->getId()?>">  <?=$item->getName()?> </a> </p>
                <p id='cart_item_price'><a href="../pages/productPage.php?product=<?=$item->getId()?>"> <?=$item->getPrice() ?>€ </a> </p>
                <form action="../actions/removeFromCart.php" method="post">
                    <input type="hidden" name="product" value=<?=$item->getId()?>> </input>
                    <input type="hidden" name="user" value="<?=$session->getUser()->getId()?>"> </input>
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
                $total += $product->getPrice();
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
        <form id ='address' action="../actions/process_purchase.php" method="post">



                <div>Street:</div> <input type='text' name='address' required="required" value= "<?=$session->getUser()->getAddress()?>">
                <div>Zipcode:</div> <input type='text' name='zipcode' required="required" value= "<?= $session->getUser()->getZipCode()?>">
                <div>City:</div> <input type='text' name='city' required="required" value= "<?= $session->getUser()->getCity()?>">
                <input type="hidden" name='paymentAuthhorization' value="paymentAuthorized">
                <?php
                output_country_option($countries);
                
                ?>
                <input type="submit" value="Pay Now">
        </form>
        </aside>
        </main>
    <?php }
?>

<?php
    function output_country_option($countries){ 
        $session = new Session();
        ?>
        
        <div class='address_field' id ='address_country'>
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