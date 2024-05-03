<?php
require_once(__DIR__ . '/../templates/common_tmpl.php');
require_once(__DIR__ . '/../templates/common_tmpl.php');


$session = new Session();
drawHeader($session);

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