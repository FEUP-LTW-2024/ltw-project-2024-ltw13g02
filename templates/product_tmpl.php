<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/user_tmpl.php');

require_once(__DIR__ . '/../vendor/autoload.php');

?>

<?php function drawProductHeader(Session $session, $idProduct) { ?>
    <a href="../pages/<?php echo $session->getPreviousPage() ?>"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
<?php } ?> 

<?php function drawProduct(Session $session, $idProduct) { ?>
    
<?php } ?> 