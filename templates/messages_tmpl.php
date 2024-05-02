<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/user_tmpl.php');

require_once(__DIR__ . '/../vendor/autoload.php');

?>

<?php function drawChatHeader(Session $session, $idChat) { 
    $info = getChatInfo($idChat); ?>
    <div class="chat-header">
        <?php $photos = getPhotos($info['idProduct']);?>
        <a href="../pages/chatsAsSellerPage.php"><i class="fa fa-angle-left fa-2x chat-back-button"></i></a>
        <img class="chat-productphoto" src="../images/products/<?php echo $photos[0]["photo"]; ?>" alt="Photo">
        <div class="chat">
            <?php if ($session->getId() == $info['SId']) { ?>
                <h2 class="with-user"><?php echo $info['BFN'] . " " . $info['BLN']; ?></h2>
            <?php } else { ?>
                <h2 class="with-user"><?php echo $info['SFN'] . " " . $info['SLN']; ?></h2>
            <?php } ?>
            <h2 class="message-product"><?php echo $info['ProdName']; ?></h2> 
        </div>
            </div>
<?php } ?> 

<?php function drawMessages(Session $session, $idChat) {
    $messages = getMessages($idChat);
    $info = getChatInfo($idChat); ?>
    <div class="column-of-messages">
        <?php foreach ($messages as $row) {
            if ($row["sender"] == $session->getId()) { ?>
                <div class="message-tile own-message">
                    <p><?php echo $row['content']; ?></p>
                </div>
            <?php } else { ?>
                <div class="message-tile other-message">
                    <p><?php echo $row['content']; ?></p>
                </div>
        <?php } ?>
    </div>
    <?php }
} ?> 

<?php function drawMessagesFooter(Session $session, $idChat) { ?>

<?php
} ?> 