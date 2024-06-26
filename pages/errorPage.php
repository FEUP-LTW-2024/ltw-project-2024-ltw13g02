<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');


$session = new Session();
drawHeader($session);

if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['error'])) {
    header('Location: ../pages/index.php');
}

if ($_GET['error']==="Tried_to_buy_bought_item"){  ?>
    <p>You tried to buy an already bought item, please try again</p> <?php
} 
else if ($_GET['error'] === "InvalidAddress") { ?>
    <p>Your address information was invalid please review it</p> <?php
}
else if ($_GET["error"]=== "noAuthorizationAccess") { ?>
    <p>You do not have authorization to access the requested page.</p> <?php
}
else {
    header('Location: ../index.php');
}

drawFooter();
?>