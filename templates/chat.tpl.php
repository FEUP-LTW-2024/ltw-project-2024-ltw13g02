<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/user.tpl.php');

require_once(__DIR__ . '/../utils/elapsedTime.php');

?>

<?php function drawChats(Session $session, $activePage) {
    $user = $session->getUser();
    if ($session->isLoggedIn()) {
        if ($activePage === 0) {
            $chats = $user->getChatsAsSellerFromDB();
        }
        else {
            $chats = $user->getChatsAsBuyerFromDB();
        }
        if (count($chats) > 0) {
            foreach ($chats as $chat) {?>
                <a href="../pages/messagesPage.php?chat=<?php echo $chat->id; ?>">
                    <div class="chat-tile">
                        <?php 
                        $product = $chat->getProduct();
                        $seller = $product->getSeller();
                        $buyer = getUserbyId($chat->possibleBuyer);
                        $photos = $product->getPhotos();
                        ?>
                        <div class="chat-product-photo-container">
                            <img class="chat-productphoto" src="../images/products/<?php echo $photos[0]["photo"]; ?>" alt="Photo">
                        </div>
                        <div class="chat-info">
                            <h2 class="with-user"><?php echo $user->id === $seller->id ? $buyer->name() : $seller->name(); ?></h2>
                            <h2 class="message-product"><?php echo $product->name; ?></h2>
                            <?php $lastmessage = $chat->getLastMessage(); 
                            if ($lastmessage->sender === $session->getUser()->id) {?>
                                <h2 class="unchecked <?php echo $lastmessage->seen ? "fa fa-check-circle" : "fa fa-check-circle-o"; ?>"></h2>
                                <h2 class="message-content"><?php echo $lastmessage->content; ?></h2>
                            <?php } else { ?>
                                <h2 class="message-content"><?php echo $lastmessage->content; ?></h2>
                                <h2 class="last-message <?php echo $lastmessage->seen ? "" : "fa fa-circle unseen"; ?>"></h2>
                            <?php } ?>
                            <h2 id="message-date"><?php echo elapsedTime($lastmessage->messageDate);?></h2>
                        </div>
                    </div>
                </a>
    <?php   }
        }
        else { ?>
            <div id="info-to-user">
                <h2 class="info-to-user">You don't have any <?php echo $activePage === 0 ? "sell" : "buy"; ?> messages yet.</h2>
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
            <li class=<?php echo $activePage === 0 ? "active" : ""; ?>><a href="../pages/chatsAsSellerPage.php"><i class="fa fa-money icon_menu"></i> To Sell</a></li>
            <li class=<?php echo $activePage === 1 ? "active" : ""; ?>><a href="../pages/chatsAsBuyerPage.php"><i class="fa fa-shopping-bag icon_menu"></i> To Buy</a></li>
        </ul>
    </nav>
<?php } ?>