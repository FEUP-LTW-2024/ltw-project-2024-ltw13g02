<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
?>

<?php function drawHeader(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <title>Pre Loved Bazaar</title>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
    </head>
    <header>
        <a href="../pages/index.php"><img class="logo" id="mainLogo" src="../imagens/logo.png" alt="ON Logo"></a>
        <a href="../pages/index.php"><img class="logo" id="chatLogo" src="../imagens/message.png" alt="ON Messages"></a>
        <a href="../pages/index.php"><img class="logo" id="settingsLogo" src="../imagens/settings.png" alt="ON Settings" ></a>
    </header>
    <body>
    </body>
    </html>
<?php } ?>

<?php function drawLoginForm() { ?>
    <form action="../actions/loginAction.php" method="post" class="login">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password">
        <a href="../pages/register.php">Register</a>
        <button type="submit">Login</button>
    </form>
<?php } ?>

<?php function drawLogoutForm(Session $session) { ?>
    <form action="../actions/logoutAction.php" method="post" class="logout">
        <a href="../pages/login.php"><?=$session->getName()?></a>
        <button type="submit">Logout</button>
    </form>
<?php } ?>
