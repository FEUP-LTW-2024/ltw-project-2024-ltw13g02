<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawAdmin(Session $session) {
    $admin = $session->getUser()->isAdmin();
    if($session->isLoggedIn()) { ?>
        
    <?php } 
} ?>