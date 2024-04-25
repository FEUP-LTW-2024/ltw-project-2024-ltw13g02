<?php
    require_once(__DIR__ . '/../database/connection.php');

    require_once(__DIR__ . '/../database/get_from_db.php');

    require_once(__DIR__ . '/../templates/common.php');
    require_once(__DIR__ . '/../templates/common_tmpl.php');
    require_once(__DIR__ . '/../templates/seller_page.php');

    require_once(__DIR__ . '/../sessions/session.php');



    //TODO remove this line after testing
    $session = new Session();
    $session->setId(1);
    $db = getDatabaseConnection();

    if (isset($_GET['user']))
    {

        $user = getUserInfo($db, $_GET['user']);

        $products = get_seller_products($db, $_GET['user']);
    }else{
        header('Location: /index.php');
    }


    if ( ($user->idUser !== $session->getId() && isset($user) && $session->isLoggedIn() ) || (is_null($session->getId())) ) {
        drawHeader($session);
        output_seller_header($db, $user);
        output_seller_products($db, $products, $user);
        output_footer();
    }else{
        header('Location: /index.php');
        //TODO link to my announces i think
    }
    