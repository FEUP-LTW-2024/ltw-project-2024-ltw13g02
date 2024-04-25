<?php
    require_once(__DIR__ . "/../database/connection.php");
    require_once(__DIR__ . '/../database/get_from_db.php');
    require_once(__DIR__ . '/../sessions/session.php');

    require_once(__DIR__ . '/../templates/common.php');


    require_once(__DIR__ . '/../templates/archive.php');


    require_once(__DIR__ . '/../templates/common_tmpl.php');

    $session = new Session();
    //TODO remove this lines after testing
    $session->setId(1);
    $session->setPhotoUser('randomImage.jpg');
    
    if ($session->isLoggedIn()) {

        $db = getDatabaseConnection();

        $products = get_archive_products($db, $session->getId());

        drawHeader($session);
        
        output_archive_user_profile($session);
        output_archive_user_products($db, $products);

        output_footer();
    }else{
        header('Location: /index.php');
    }
    
