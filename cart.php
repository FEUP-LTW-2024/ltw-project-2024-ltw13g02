<?php
    require_once('database/connection.php');
    require_once('templates/common.php');
    require_once('templates/shopingCart.php');
    output_header();
    $db = getDatabaseConnection();
    $items = getUserShopingCart($db, $_SESSION['idUser']);
    output_cart_items($items);
    //output_cart_price();
    output_footer();
