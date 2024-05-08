<?php

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/user_tmpl.php');

$user = $session->getUser();
$product = getProduct($_GET['product']);

foreach ($other_user->getChatsAsBuyerFromDB() as $chat) {
    //TODO
}