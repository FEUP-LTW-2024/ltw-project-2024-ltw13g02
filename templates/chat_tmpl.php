<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/user_tmpl.php');

require_once(__DIR__ . '/../utils/elapsedTime.php')

?>

<?php function drawChats(Session $session, $activePage) {
    if ($session->getEmail() != null) {
        if ($activePage == 0) $chats = getChatsAsSellerFromDB($session->getId());
        else $chats = getChatsAsBuyerFromDB($session->getId());
        if (count($chats) > 0) {
            foreach ($chats as $row) {?>
                <a href="../pages/messagesPage.php?chat=<?php echo $row['idChat']; ?>">
                    <div class="chat-tile">
                        <?php drawOtherUserPhoto($row["photo"]); ?>
                        <div class="chat-info">
                            <h2 class="with-user"><?php echo $row['firstName'] . " " . $row['lastName']; ?></h2>
                            <?php $lastmessage = getLastMessage($row['idChat']); 
                            if ($lastmessage["sender"] == $session->getId()) {?>
                                <h2 class="unchecked <?php echo $lastmessage["seen"] ? "fa fa-check-circle" : "fa fa-check-circle-o"; ?>"></h2>
                                <h2 class="message-content"><?php echo $lastmessage['content']; ?></h2>
                            <?php } else { ?>
                                <h2 class="message-content"><?php echo $lastmessage['content']; ?></h2>
                                <h2 class="last-message <?php echo $lastmessage["seen"] ? "" : "fa fa-circle unseen"; ?>"></h2>
                            <?php } ?>
                            <h2 id="message-date"><?php echo elapsedTime($lastmessage['messageDate']);?></h2>
                        </div>
                    </div>
                </a>
    <?php   }
        }
        else { ?>
            <div id="info-to-user">
                <h2 class="info-to-user">You don't have any <?php echo $activePage == 0 ? "sell" : "buy"; ?> messages yet.</h2>
            </div>
    <?php }
    }
    else { ?>
    <div id="info-to-user">
        <h2 class="info-to-user">You need to sign up to check your messages.</h2>
    </div>
<?php }
} ?>

<?php function drawHamburguerChat(Session $session, $activePage) { ?>
    <nav id="menu">
        <input type="checkbox" id="hamburger"/> 
        <label class="hamburger" for="hamburger"></label>
        <ul class="chat-menu">
            <li class=<?php echo $activePage == 0 ? "active" : ""; ?>><a href="../pages/chatsAsSellerPage.php"><i class="fa fa-money icon_menu"></i> To Sell</a></li>
            <li class=<?php echo $activePage == 1 ? "active" : ""; ?>><a href="../pages/chatsAsBuyerPage.php"><i class="fa fa-shopping-bag icon_menu"></i> To Buy</a></li>
        </ul>
    </nav>
<?php } ?>

<?php function drawOtherUserPhoto($photo) { ?>
        <div class="chat-user-photo-container">
            <?php if ($photo == "Sem foto") { ?>
                <a href="../pages/editingProfile.php" class="user-icon-link">
                    <i class="fa fa-user fa-5x chat-userphoto"></i>
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } else { ?>
                <a href="../pages/editingProfile.php" class="user-photo-link">
                    <img class="chat-userphoto" src="../images/userProfile/<?php echo $photo; ?>" alt="Photo">
                    <a href="../pages/editingProfile.php"><i class="fa fa-pencil edit-icon fa-1x"></i></a>
                </a>
            <?php } ?>
        </div>
<?php } ?>