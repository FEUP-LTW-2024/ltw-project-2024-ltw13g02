<?php
    require_once(__DIR__ . "/../database/get_from_db.php");
    require_once(__DIR__ . '/../database/get_from_db.php');
    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../templates/common.php');


    require_once(__DIR__ . '/../templates/archive.php');


    require_once(__DIR__ . '/../templates/common.tpl.php');

    $session = new Session();

    if ($session->isLoggedIn()) {

        $user = $session->getUser();
        $products = $user->getArchiveProducts();

        drawHeader($session);
    
        output_archive_user_profile($session);
        output_archive_user_products($products);

        drawFooter();
    }else{
        header('Location: ../index.php');
    }
    
