<?php

    require_once(__DIR__ . '/../database/connection.php');
    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/shopingCart_tmpl.php');
    require_once(__DIR__ . '/../templates/common_tmpl.php');


    if (!$session->isLoggedIn()) { header('Location: /index.php'); } 

    $db = getDatabaseConnection();

    $items_ids = getUserShopingCart($db, $session->getId());

    $countries = getAllCountries($db);
    
    drawHeader($session);
    ?>
    <link rel="stylesheet" href="../css/cart.css">

    <?php
    if (sizeof($items_ids) > 0) {
        output_cart_items($items_ids);
        output_shipping_address($session, $countries);
    } else {
        output_empty_cart();
    }
    drawFooter();
