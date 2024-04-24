<?php

    require_once('database/connection.php');

    require_once('templates/common.php');

    require_once('templates/seller_page.php');


    session_start(); //TODO remove session start
    $_SESSION['idUser'] = 1;

    $db = getDatabaseConnection();
    $user = getUserPublicInfo($db, $_GET['user']);
    $products = get_seller_products($db, $_GET['user']);


    if ($user !== $_SESSION['idUser']) {
        output_header();     
        output_seller_header($db, $user);
        output_seller_products($db, $products, $user);
        output_footer();
    }else{
        //TODO header() para personal profile
    }
    
