<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');
  require_once(__DIR__ . '/../database/get_from_db.php');
  require_once(__DIR__ . '/../database/userClass.php');


  require_once(__DIR__ . '/../templates/common_tmpl.php');
  require_once(__DIR__ . '/../templates/productsprint_tmpl.php');

  $db = getDatabaseConnection();
  $categories = getCategories($db);

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
  
  drawFooter();
?>
