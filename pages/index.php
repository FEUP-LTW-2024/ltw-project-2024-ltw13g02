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
<body>
    <main>
        <form id="search">
            <select name="fruit">
                <option value="All" selected>All</option>
                <option value="Roupa">Roupa</option>
                <option value="Tecnologia">Tecnologia</option>
                <option value="Livros">Livros</option>
            </select>
            <input type="search" name="searchbar" required>
        </form>
        <section class="Products" id="Recent">
            <h2>Recents</h2>
            <article>
                <!-- PHP fica aqui -->
                <div class="offers_container">
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                    <div class="offer">
                        <a href="main.html" class="user_small_card"><img class="user_small_pfp" src="../imagens/randomImage.jpg"> <p>Cute User</p></a>
                        <a href="main.html"><img class="offer_img" src="../imagens/randomImage.jpg"></a>
                        <div class="offer_info">
                            <h4>A minha dignidade</h4> <!-- TODO adicionar size restriction-->
                            <h5>Porto, Portugal</h5>
                            <p>1000.00 €</p>
                        </div>
                    </div>
                </div>
                <input type="submit" value="&#60" class="MovArrows" >
                <input type="submit" value=">" class="MovArrows">
            </article>

        </section>

        <section class="Products" id="Favorites">
            <h2>Favorites</h2>
            <article>
                <!-- PHP fica aqui -->
                <div class="offers_container">
                    <div class="offer">F1</div>
                    <div class="offer">F2</div>
                    <div class="offer">F3</div>
                    <div class="offer">F4</div>
                    <div class="offer">F5</div>
                    <div class="offer">F6</div>
                    <div class="offer">F7</div>
                    <div class="offer">F8</div>
                    <div class="offer">F9</div>
                </div>
                <input type="submit" value="&#60" class="MovArrows" >
                <input type="submit" value=">" class="MovArrows">
            </article>

            <!-- PHP fica aqui -->
            <!--
            <input type="submit" value="Move Left"class="MovArrows">
            <input type="submit" value="Move Right" class="MovArrows">
            -->
        </section>

        <article class="Products" id="Recommended">
            <!-- Provavelmente o resto é um loop de PHP aqui-->
        </article>
    </main>
</body>