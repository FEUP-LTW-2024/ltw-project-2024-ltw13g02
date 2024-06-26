<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/user.class.php');


  require_once(__DIR__ . '/../templates/common.tpl.php');
  require_once(__DIR__ . '/../templates/productsprint.tpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
  drawHamburguer($session, 2);

  if ($session->isLoggedIn()) {

    $user = $session->getUser();
    $archive_ids = $user->getArchive();

    if (sizeof($archive_ids) > 0) {drawArchive($archive_ids); }
  else { ?>
    <div class="user-info">
      <h2><?php echo "No Products in Archive"; ?></h2>
    </div>  
  <?php }
  }
  
?>
