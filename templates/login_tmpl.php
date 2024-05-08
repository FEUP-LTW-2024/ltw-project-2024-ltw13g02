<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawLogin() { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <title>Login</title>
            <link rel="stylesheet" href="../css/forms.css">
            <link rel="stylesheet" href="../css/style.css">

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Didact+Gothic&display=swap" rel="stylesheet">
        </head>
        <body class="log">
            <div class="login">
                <form id = "login" action="../actions/loginAction.php" method="post">
                    <h1>Login</h1>
                    <label id="email" class="required">
                        <input type="text" name="email" placeholder=" Email..." required>
                    </label>
                    <label id="password" class="required">
                        <input type="password" name="password" placeholder=" Password..." required>
                    </label>
                    <?php
                        if(ISSET($_SESSION['error'])){
                    ?>
                            <div class="alert alert-danger"><?php echo $_SESSION['error']?></div>
                    <?php
                            unset($_SESSION['error']);
                        }
                    ?>
                    <a href="index.php"><button id="Blogin" class="button" type="submit">Login</button></a>
                    <a href="register.php"><h2 id="goToReg">I don't have an account</h2></a>
                </form>
            </div>
        </body>
    </html>
<?php } ?>
