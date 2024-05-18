<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
$db = getDatabaseConnection();

$user = $session->getUser();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user) {
    $rawPostData = file_get_contents('php://input');
    $postData = json_decode($rawPostData, true);

    if (isset($postData['idPhoto'], $postData['product_id'])) {
        $photoId = $postData['idPhoto'];
        $productId = $postData['product_id'];
        
        $product = getProduct($productId);
        if ($product->getSeller()->id !== $user->id) {
            http_response_code(403);
            echo json_encode(["message" => "Unauthorized"]);
            exit;
        }

        if (deletePhoto($photoId)) {
            echo json_encode(["message" => "Photo deleted successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to delete photo"]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Invalid request data"]);
    }
}

function deletePhoto($idPhoto) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('DELETE FROM Photo WHERE idPhoto = ?');

    if ($stmt->execute([$idPhoto])) {
        return true;
    } else {
        error_log("Error deleting photo with id: $idPhoto");
        return false;
    }
}
?>
