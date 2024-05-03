<?php
    require_once(__DIR__ . '/../database/connection.php');

    require_once(__DIR__ . '/../database/get_from_db.php');

    require_once(__DIR__ . '/../templates/common_tmpl.php');
    require_once(__DIR__ . '/../templates/seller_page_tmpl.php');

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    $db = getDatabaseConnection();

    if (isset($_GET['user'])) {
        $user = getUserInfo($db, $_GET['user']);

        $products = get_seller_products($db, $_GET['user']);
    } else {
        header('Location: /index.php');
        exit();
    }
    
    if ( $session->isLoggedIn() ) {
        drawHeader($session);
        output_seller_header($db, $user);
        output_seller_products($db, $products, $user);
        drawFooter();
    } else {
        header('Location: /index.php');
        exit();
        //TODO link to my announces i think
    }
    
