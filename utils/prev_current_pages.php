<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../sessions/session.php');


?>

<?php function updatePages($session, $page) {
    $session->setPreviousPage(isset($_SESSION['current-page']) ? $session->getCurrentPage() : "index.php");
    $session->setCurrentPage($page);    
} ?>