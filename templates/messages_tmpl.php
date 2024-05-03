<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/../database/change_in_db.php');

require_once(__DIR__ . '/user_tmpl.php');

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
    setAsSeen($idChat, $session->getId()); ?>
    <div class="column-of-messages">
        <?php foreach ($messages as $key => $row) { ?>
            <?php if ($row["sender"] == $session->getId()) { ?>
                <div class="message-container">
                    <div class="message-tile message own-message">
                        <p><?php echo $row['content']; ?></p>
                    </div>
                    <h2 class="message-status <?php echo $row['seen'] ? "fa fa-check-circle" : "fa fa-check-circle-o"; ?>"></h2>
                </div>
                <?php
                if ($key < count($messages) - 1 && strtotime($row['messageDate']) - strtotime($messages[$key + 1]['messageDate']) < 3600) {
                } 
                else { ?>
                    <div class="time">
                        <p><?php echo $row['messageDate']; ?></p>
                    </div>
                <?php } 
             } else { 
            ?>
            <div class="message-tile message other-message">
                <p><?php echo $row['content']; ?></p>
            </div>
            <?php
                if ($key < count($messages) - 1 && strtotime($row['messageDate']) - strtotime($messages[$key + 1]['messageDate']) < 3600) {
                } 
                else { ?>
                    <div class="time">
                        <p><?php echo $row['messageDate']; ?></p>
                    </div>
                <?php }
             } 
            } ?>
    </div>
<?php } ?> 

<?php function drawMessagesFooter(Session $session, $idChat) { ?>
        <div class="input">
            <form method="post" action="" class="messages-input-form">
                <input name="message" placeholder="Type your message here!" type="text">
                <button id="Send" type="submit" class="Send"><i class="fa fa-paper-plane fa-1x icon send-icon"></i></button>
            </form>    
        </div>
    </body>
</html>
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = $_POST['message'];
        addMessage($session->getId(), $idChat, $message);

        header("Location: ".$_SERVER['PHP_SELF']."?chat=".urlencode($idChat));
    }
} ?> 