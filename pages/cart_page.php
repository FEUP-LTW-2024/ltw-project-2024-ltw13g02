<?php

    require_once(__DIR__ . '/../database/get_from_db.php');

    require_once(__DIR__ . '/../templates/common.tpl.php');

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/shopingCart.tpl.php');
    require_once(__DIR__ . '/../templates/common.tpl.php');


    if (!$session->isLoggedIn()) { header('Location: /index.php'); } 

    $user = $session->getUser();

    $items_ids = $user->getShoppingCart();

    $countries = getAllCountries();
    
    drawHeader($session);
    ?><script src="../javascript/cart.js" defer></script> <?php
    if (sizeof($items_ids) > 0) {
        output_cart_items($items_ids);
        output_shipping_address($session, $countries);
    } else {
        output_empty_cart();
    }
    drawFooter();
