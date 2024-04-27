<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');

require_once(__DIR__ . '/../database/get_from_db.php');

require_once(__DIR__ . '/user_tmpl.php');

?>

<?php function drawMessages(Session $session, $idChat) {
    $messages = getMessages($idChat);
    foreach ($messages as $row) {
        if ($row["sender"] == $session->getId()) { ?>
            <div class="message-tile own-message">
                <p><?php echo $row['content']; ?></p>
            </div>
        <?php } else { ?>
            <div class="message-tile other-message">
            </div>
<?php   }
    }
} ?> 