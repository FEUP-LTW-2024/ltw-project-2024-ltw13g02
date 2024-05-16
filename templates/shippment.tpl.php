<?php
    function drawShippingHeader(string $purchaseDate) { 
        list($day,$hour) = explode(' ',$purchaseDate)?>
        <main>
        <h2>Shipping Form</h2>
        <h3><?="Transaction Ocoured on {$day} at {$hour}"?></h3>
        <?php
    }
?>


<?php
    function drawShippingProducts(Shipping $shipping) {
        $products = $shipping->getProducts();?>
        <section id="ShippingProducts"> <?php
            foreach ($products as $product) {
                drawShippingProduct($product);
            } ?>
            <div class="ShippingProduct">
                <p>Total:</p>
                <span><?=""?></span>
                <p><?=$shipping->total?>€</p>
        </div> 
        </section> <?php
    }
?>

<?php
    function drawShippingProduct(Product $product) { ?>
    <a href="../pages/productPage.php?product=<?=$product->id?>">
        <div class="ShippingProduct">
            <p><?=$product->name?>:</p>
            <span><?=""?></span>
            <p><?=$product->price?>€</p>
        </div> 
    </a> <?php
    }

?>

<?php
  function drawShippingUsers(Shipping $shipping) {
    $seller = $shipping->seller;
    $buyer = $shipping->buyer;
    ?>
    <section>
        <p><strong>Seller:</strong> <?=$seller->name()?></p>
        <p><strong>Shipping from:</strong> <?=$shipping->drawSellerFullAddress()?></p>
        <p><strong>Buyer:</strong> <?=$buyer->name()?></p>
        <p><strong>Shipping to:</strong> <?=$shipping->drawBuyerFullAddress()?></p>
    </section>
    </main>
    <?php
    }
?>