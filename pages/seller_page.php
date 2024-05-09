<?php
    require_once(__DIR__ . '/../database/get_from_db.php');

    require_once(__DIR__ . '/../templates/common_tmpl.php');
    require_once(__DIR__ . '/../templates/user_tmpl.php');
    require_once(__DIR__ . '/../templates/seller_page_tmpl.php');

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();
    $user = getUserbyId($_GET['user']);
    $db = getDatabaseConnection();

    if (isset($user)) {
        $seller = getUserbyId($user->getId());

        $products = $seller->getSellingProducts();
    } else {
        header('Location: /index.php');
        exit();
    }
    if ((!$session->isLoggedIn()) or ($session->isLoggedIn() and ($session->getUser()->getId() !== $user->getId())) ) {
        drawHeader($session);
        output_seller_header($db, $user);
        output_seller_products($db, $products, $user);
        drawFooter();
    } else {
        header('Location: /index.php');
        exit();
    }
    
