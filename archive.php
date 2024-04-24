<?php

    require_once('database/connection.php');

    require_once('templates/common.php');

    require_once('templates/archive.php');


    session_start(); //TODO remove session start
    $_SESSION['idUser'] = 1;

    $db = getDatabaseConnection();
    $products = get_archive_products($db, $_GET['user']);


    if (isset($_SESSION['idUser'])) {

        output_header();     
        
        

        output_footer();
    }else{
        //TODO header() para main i guess
    }
    
