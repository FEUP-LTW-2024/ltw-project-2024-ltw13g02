<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../sessions/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection_to_db.php');

  require_once(__DIR__ . '/../templates/common_tmpl.php');

  $db = getDatabaseConnection();

  drawHeader($session);
  drawHamburguer($session);
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
        <?php $email = $session->getEmail(); ?>
        <h2>
          <?php 
              $photo = $session->getPhotoUser(); 

              if($email == null){
                //nada
              }else if ($photo == "Sem foto") {
                  echo "Sem foto";
              } else{
                  echo '<img class="userphoto" src= ../imagens/userProfile/'.$photo.' alt="Foto">';
              }
          ?>
        </h2>
        <h2><?php echo $email = $session->getEmail(); ?></h2>
        <h2>
              <?php
                $stars = $session->getStars();
                if($email == null){
                  //ainda não deu login
                }else if ($stars == 0) {
                    echo "0 Stars";
                } else {
                    for ($i = 0; $i < $stars; $i++) {
                        echo '<img class="star" src="star.jpeg" alt="Star">';
                    }
                }
              ?>
            </h2>
        <h2><?php echo $session->getFirstName() . " " . $session->getLastName(); ?></h2>
    </div>
    <div class="links">
      <?php if($email != null) { ?>       
        <a href="pagina_de_mudar_coisas_perfil"><h2>Change personal info</h2></a>
        <a href="pagina_anuncios_user"><h2>Change profile picture</h2></a>
        <!-- <a href="pagina_anuncios_user"><h2>My announces</h2></a>
        <a href="pagina_arquivo"><h2>Archive</h2></a> -->
        <!--<a href="logout.php"><h2 id="Logout">Logout</h2></a> -->
      <?php } else { ?>
        <!--<a href="login.php"><h2 id="goToLogin">Login</h2></a> --> <!-- user n deu login -->
      <?php } ?>   
</div>

  </body>
</html>

