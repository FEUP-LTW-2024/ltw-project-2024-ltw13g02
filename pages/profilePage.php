<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<main class="center-text">
    <div class="user-info">
        <h2><?php echo $session->getEmail(); ?></h2>
        <h2>Stars: <?php echo $session->getStars(); ?></h2>
        <h2><?php echo $session->getFirstName() . " " . $session->getLastName(); ?></h2>
    </div>
    <div class="links">
        <a href="pagina_de_mudar_coisas_perfil"><h2>Change personal info</h2></a>
        <a href="pagina_anuncios_user"><h2>My announces</h2></a>
        <a href="pagina_arquivo"><h2>Archive</h2></a>
        <a href="login.php"><h2 id="goToLogin">Login</h2></a>
        <a href="logout.php"><h2 id="Logout">Logout</h2></a>
    </div>
</main>

</body>
</html>

