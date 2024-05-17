<?php
require_once(__DIR__ . '/../sessions/session.php');

$reviewText = $_POST["reviewText"];
$stars = $_POST['stars'];
$reviewedUser = getUserbyId($_POST['reviewedUser']);
$session = new Session();
$CSRF= $session->getCSRF();




if (!isset($reviewText) or !isset($reviewedUser) or !isset($stars) or
    strlen($reviewText) > 500 or $reviewedUser->id === $session->getUser()  or !preg_match("/^[0-5]$/", $stars) or $CSRF !== $session->getCSRF()) {

        header('Location: ../index.php');
        exit();
}
$reviewText = trim($reviewText);
$reviewText = htmlspecialchars($reviewText);
$stars = intval($stars);


if (strlen($reviewText) === 0) {
    header("Location: ../pages/reviewsPage.php?user={$reviewedUser->id}");
    exit;
}



$db = getDatabaseConnection();
$stmt = $db->prepare("INSERT INTO Reviews (stars, idUser, reviewsDescription, idUserFrom, created_at)
                        VALUES (?,?,?,?,?);");
$stmt->execute(array($stars,$reviewedUser->id,$reviewText,$session->getUser()->id,date('Y-m-d H:i')));

header("Location: ../pages/reviewsPage.php?user={$reviewedUser->id}");