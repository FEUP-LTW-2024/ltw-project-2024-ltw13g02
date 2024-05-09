<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../sessions/session.php');
    $session = new Session();

    require_once(__DIR__ . '/../database/connection_to_db.php');

    require_once(__DIR__ . '/../templates/common_tmpl.php');

    require_once(__DIR__ . '/../templates/productsprint_tmpl.php');
    
    if (!$session->isLoggedIn()) { header('Location: /index.php'); } 

    drawHeader($session);
    $user = $session->getUser();
    $favorites_ids = $user->getFavorites();
    dd($favourites_ids);
    if ($favourites_ids != null) {drawFavorites($favourites_ids);}
    else {
        ?>
        <h2 id="no-favs">You don't have favorites yet! </h2>
        <?php
    }
    drawFooter();