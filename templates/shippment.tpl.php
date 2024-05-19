<?php
    function drawShippingHeader(string $purchaseDate) { ?>
        
        <main id="shippingForm">
        <h2>Shipping Form</h2>
        <h3><?="Transaction Ocoured on {$purchaseDate}"?></h3>
        <?php
    }
?>


<?php
    function drawShippingProducts(Shipping $shipping) {
        $products = $shipping->getProducts();?>
        <section id="ShippingProducts"> <?php
            foreach ($products as $product) {
                drawShippingProduct($product);
            }
            $ports = 0;
            if ($shipping->buyerCountry !== $shipping->sellerCountry){
                $ports = 5 * count($products);
            }
            ?>
            <div class="ShippingProduct">
                <p>Order:</p>
                <span><?=""?></span>
                <p><?=$shipping->total-$ports?>€</p>
            </div>
            <div class="ShippingProduct">
                <p>Ports:</p>
                <span><?=""?></span>
                <p><?=$ports?>€</p>
            </div> 
            <div class="ShippingProduct">
                <p id="idTotal"><strong>Total:</p>
                <span><?=""?></span>
                <p><?=$shipping->total?>€</p>
            </div> 
        </section> <?php
    }
?>

<?php
    function drawShippingProduct(Product $product) { ?>
        <div class="ShippingProduct">
            <p><?=$product->name?>:</p>
            <span><?=""?></span>
            <p><?=$product->price?>€</p>
        </div> <?php
    }

?>

<?php
  function drawShippingUsers(Shipping $shipping) {
    $seller = $shipping->seller;
    $buyer = $shipping->buyer;
    ?>
    <section id="shippingUsers">
        <a href="../pages/seller_page.php?user=<?=$seller->id?>"><p><strong>Seller:</strong> <?=$seller->name()?></p></a>
        <p><strong>Shipping from:</strong> <?=$shipping->drawSellerFullAddress()?></p>
        <a href="../pages/seller_page.php?user=<?=$buyer->id?>"><p><strong>Buyer:</strong> <?=$buyer->name()?></p></a>
        <p><strong>Shipping to:</strong> <?=$shipping->drawBuyerFullAddress()?></p>
    </section>
    </main>
    <?php
    }
?>