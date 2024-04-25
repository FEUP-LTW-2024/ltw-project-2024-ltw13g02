<?php

    require_once(__DIR__ . '/../database/connection.php');

    require_once(__DIR__ . '/../templates/common.php');


    require_once(__DIR__ . '/../templates/archive.php');


    require_once(__DIR__ . '/../templates/common_tmpl.php');


    $session = new Session();
    $session->setId(1); //TODO remove


    if ($session->isLoggedIn()) {
        $db = getDatabaseConnection();

        $products = get_archive_products($db, $session->getId());

        $user = getUser("admin@admin.com","test");

        drawHeader($session);     
        
        output_archive_user_profile();
        output_archive_user_products($db, $products);

        output_footer();
    }else{
        header('Location: pages/index.php');
    }
    
