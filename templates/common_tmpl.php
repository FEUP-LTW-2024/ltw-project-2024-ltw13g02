<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
?>

<?php function drawHeader(Session $session) { ?>
    <head>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/responsive.css">
        <link rel="stylesheet" href="../css/layout.css">
        <title>Pre Loved Bazaar</title>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    </head>
    <header>
        <a href="../pages/index.php"><h2 id="mainLogo">PRE LOVED BAZAAR</h2></a>
        <a href="../pages/index.php"><i class="fa fa-comments fa-2x icon"></i></a>
        <a href="../pages/profilePage.php"><i class="fa fa-user fa-2x icon"></i></a>
        <?php if($session->getEmail() != null) { ?>
            <a href="../pages/logout.php"><i class="fa fa-sign-out fa-2x icon"></i></a>
        <?php } else { ?>
            <a href="../pages/login.php"><i class="fa fa-sign-in fa-2x icon"></i></a>
        <?php } ?> 
    </header>
<?php } ?>

<?php function drawHamburguer(Session $session) { ?>
    <?php if($session->getEmail() != null) { ?>
        <nav id="menu">
            <input type="checkbox" id="hamburger"/> 
            <label class="hamburger" for="hamburger"></label>
            <ul>
                <li><a href="../pages/profilePage.php"><i class="fa fa-user-secret fa-1x icon_menu"></i> Personal Info</a></li>
                <li><a href="../pages/myAnnouncements.php"><i class="fa fa-bullhorn fa-1x icon_menu"></i> My announcements</a></li>
                <li><a href="../pages/myArchive.php"><i class="fa fa-archive fa-1x icon_menu"></i> Archive</a></li>
            </ul>
        </nav>
    <?php } 
    } ?>
