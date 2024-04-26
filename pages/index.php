<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();
    $session->setId(1);
  require_once(__DIR__ . '/../database/connection_to_db.php');
  require_once(__DIR__ . '/../database/connection.php');
  require_once(__DIR__ . '/../database/userClass.php');


  require_once(__DIR__ . '/../templates/common_tmpl.php');
  require_once(__DIR__ . '/../templates/index_tmp.php');


  $db = getDatabaseConnection();
  $categories = getCategories($db);
  drawHeader($session);
  drawSearchbar($categories);

  if ($session->isLoggedIn()) 
  {
    $user = getUserInfo($db,$session->getId());
    $recent_ids = $user->getRecent($db);
    $favourites_ids = $user->getFavorites($db);

    if (sizeof($recent_ids) > 0){drawRecent($recent_ids, $db); }
    if (sizeof($favourites_ids) > 0){drawFavorites($favourites_ids, $db); }
    $recommended_ids = getRecommended($db, $session->getId());
    drawRecommended($db,$recommended_ids);

  }
?>
</main>
</body>