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

<?php if (isset($db)){ exit();} ?>
<!DOCTYPE html>
<html lang="en-US">
<body>
    <main>
        <section class="Products" id="Recent">
            <h2>Recents</h2>
            <article>
                <!-- PHP fica aqui -->
                <div class="offers_container">
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>

                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="sliding_offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="imagens/randomImage.jpg"></a>

                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                </div>
                <input type="submit" value="&#60" class="MovArrows">
                <input type="submit" value=">" class="MovArrows">
            </article>

        </section>

        <section class="Products" id="Favorites">
            <h2>Favorites</h2>
            <article>
                <!-- PHP fica aqui-->
                <div class="offers_container">
                    <div class="sliding_offer">F1</div>
                    <div class="sliding_offer">F2</div>
                    <div class="sliding_offer">F3</div>
                    <div class="sliding_offer">F4</div>
                    <div class="sliding_offer">F5</div>
                    <div class="sliding_offer">F6</div>
                    <div class="sliding_offer">F7</div>
                    <div class="sliding_offer">F8</div>
                    <div class="sliding_offer">F9</div>
                </div>
                <input type="submit" value="&#60" class="MovArrows" >
                <input type="submit" value=">" class="MovArrows">
            </article>

            <!-- PHP fica aqui-->
            <input type="submit" value="Move Left"class="MovArrows">
            <input type="submit" value="Move Right" class="MovArrows">
            
        </section>

        <article class="Products" id="Recommended">
            <!-- Provavelmente o resto é um loop de PHP aqui-->
        </article>
    </main>
</body>