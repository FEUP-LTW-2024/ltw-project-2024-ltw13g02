<?php

    require_once(__DIR__ . '/../database/get_from_db.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/shopingCart.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');

    $user = $session->getUser();

    $countries = getAllCountries();
    
    drawHeader($session);
    if (!$session->isLoggedIn()) { ?>
        <h2 id="no-favs">You need to sign up to add products to shopping cart! </h2>
    <?php } else { 
        $items_ids = $user->getShoppingCart(); ?>
        <script src="../javascript/cart.js" defer></script> <?php
        if (sizeof($items_ids) > 0) {
            output_cart_items($items_ids);
            output_shipping_address($session, $countries);
        } else {
            output_empty_cart();
        }
    }    
    drawFooter();
