<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../sessions/session.php');

?>

<?php function drawHeader(Session $session) { ?>
    <!DOCTYPE html>
    <html lang="en-US">
        <head>
            <link rel="stylesheet" href="../css/style.css">
            <link rel="stylesheet" href="../css/responsive.css">
            <link rel="stylesheet" href="../css/layout.css">
            <title>Dealify</title>
            <meta charset="utf-8">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        </head>
        <body>
        <header>
            <a href="../pages/index.php"><h2 id="mainLogo">Dealify</h2></a>
            <a href="../pages/newProduct.php"><h2 class="header-icons"><i class="fa fa-plus fa-1x icon"></i></h2></a>
            <a href="../pages/favoritesPage.php"><h2 class="header-icons"><i class="fa fa-heart fa-1x icon"></i></h2></a>
            <a href="../pages/cart_page.php"><h2 class="header-icons"><i class="fa fa-shopping-cart fa-1x icon"><span class="small"><?php echo $session->isLoggedIn() ? count($session->getUser()->getShoppingCart()) : '' ?></span></i></h2></a>
            <a href="../pages/chatsAsSellerPage.php"><h2 class="header-icons"><i class="fa fa-comments fa-1x icon"></i></h2></a>
            <a href="../pages/profilePage.php"><h2 class="header-icons"><i class="fa fa-user fa-1x icon"></i></h2></a>
            <?php if($session->isLoggedIn()) { ?>
                <a href="../pages/logout.php"><h2 class="header-icons"><i class="fa fa-sign-out fa-1x icon"></i></h2></a>
            <?php } else { ?>
                <a href="../pages/login.php"><h2 class="header-icons"><i class="fa fa-sign-in fa-1x icon"></i></h2></a>
            <?php } 
            ?> 
        </header>
<?php } ?>

<?php function drawHamburguer(Session $session, $activePage) {
    if($session->isLoggedIn()) { 
        $admin = $session->getUser()->isAdmin(); ?>
        <nav id="menu">
            <input type="checkbox" id="hamburger"/> 
            <label class="hamburger" for="hamburger"></label>
            <ul id=<?php echo $admin ? "adminHeader" : ""; ?>>
                <li class=<?php echo $activePage === 0 ? "active" : ""; ?>><a href="../pages/profilePage.php"><i class="fa fa-user-secret icon_menu"></i> Personal Info</a></li>
                <li class=<?php echo $activePage === 1 ? "active" : ""; ?>><a href="../pages/myAnnouncements.php"><i class="fa fa-bullhorn icon_menu"></i> Announcements</a></li>
                <li class=<?php echo $activePage === 2 ? "active" : ""; ?>><a href="../pages/myArchive.php"><i class="fa fa-archive icon_menu"></i> Archive</a></li>
                <?php if ($admin) { ?>
                <li class=<?php echo $activePage === 4 ? "active" : ""; ?>><a href="../pages/adminPage.php"><i class="fa fa-key icon_menu"></i> Admin Page</a></li>
                <?php } ?>
            </ul>
        </nav>
    <?php } 
} ?>


<?php function drawFooter() { ?>
        <footer>
                <p>&copy; Dealify </p>
        </footer>
        </body>
    </html>
<?php } ?>