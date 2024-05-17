<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../sessions/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../templates/common.tpl.php');
require_once(__DIR__ . '/../templates/product.tpl.php');

$db = getDatabaseConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $prodName = $_POST['prodName'];
    $prodDescription = $_POST['prodDescription'];
    
    $price = $_POST['price'];
    $price = str_replace(',', '.', $price);
    $price = floatval($price);

    $condition = $_POST['condition'];
    $category = $_POST['category'];

    $userId = $session->getUser()->id;
    $photoDir = __DIR__ . '/../images/products/';
    if($_FILES["photosProd"]["name"] != null){
        $photoOriginalName = $_FILES["photosProd"]["name"];
        $photoExtension = pathinfo($photoOriginalName, PATHINFO_EXTENSION);
        $photoName = $userId . '_' . $photoOriginalName;
        $photoTmpName = $_FILES["photosProd"]["tmp_name"];
        $photoPath = $photoDir . $photoName;
        
        if (move_uploaded_file($photoTmpName, $photoPath)) {
            echo "The file " . htmlspecialchars($photoName) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        $photoName = null;
    }

    
    
    $nonNullCharacteristics = [];
    foreach ($_POST['characteristics'] as $characteristic) {
        if ($characteristic !== null && $characteristic !== "") {
            $nonNullCharacteristics[] = $characteristic;
        }
    }

    $char1 = $nonNullCharacteristics[0] ?? null;
    $char2 = $nonNullCharacteristics[1] ?? null;
    $char3 = $nonNullCharacteristics[2] ?? null;

    header("Location: ../actions/newProdAction.php?prodName=$prodName&prodDescription=$prodDescription&price=$price&condition=$condition&characteristic1=$char1&characteristic2=$char2&characteristic3=$char3&photosProd=$photoName");
    exit;
}

$db = getDatabaseConnection();
$conditions = getConditions();
$categories = getCategories();

drawHeader($session);
drawNewProduct($session, $conditions, $categories);
drawFooter();
?>
