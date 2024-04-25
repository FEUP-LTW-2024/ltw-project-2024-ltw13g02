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
  <body>
    <main>
      <div class="user-info">
        <section class="Products" id="Announcements">
            <h2>My Announcements</h2>
            <article>
                <!-- PHP fica aqui -->
                <div class="offers_container">
                    <div class="offer">A1</div>
                    <div class="offer">A2</div>
                    <div class="offer">A3</div>
                    <div class="offer">A4</div>
                    <div class="offer">A5</div>
                    <div class="offer">A6</div>
                    <div class="offer">A7</div>
                    <div class="offer">A8</div>
                    <div class="offer">A9</div>
                </div>
                <!--<input type="submit" value="&#60" class="MovArrows" >
                <input type="submit" value=">" class="MovArrows">-->
            </article>

            <!-- PHP fica aqui -->
            <!--
            <input type="submit" value="Move Left"class="MovArrows">
            <input type="submit" value="Move Right" class="MovArrows">
            -->
        </section>
      </div>
    </main>

  </body>
</html>

