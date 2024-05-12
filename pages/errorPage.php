<?php
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/common.tpl.php');


$session = new Session();
drawHeader($session);

if ( !preg_match ("/^[a-zA-Z0-9\s]+$/", $_GET['error'])) {
    header('Location: pages/index.php');
}

if ($_GET['error']==="Tried_to_buy_bought_item"){ ?>
    <p>You tried to buy an already bought item, please try again</p>
<?php
} else {
    header('Location: ../index.php');
}
?>



<?php
drawFooter();
?>