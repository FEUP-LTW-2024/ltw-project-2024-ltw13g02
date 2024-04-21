<?php
    require_once('database/connection.php');
    require_once('templates/common.php');
    require_once('templates/shopingCart.php');
    session_start();
    $_SESSION['idUser'] = 1;

    $db = getDatabaseConnection();
    $items = getUserShopingCart($db, $_SESSION['idUser']);
    $address = getUserAddress($db, $_SESSION['idUser']);
    $countries = getAllCountries($db);

    output_header();
    ?>
    <link rel="stylesheet" href="cart.css">
    <?php
    output_cart_items($items);
    output_shipping_address($address, $countries);

    output_footer();
