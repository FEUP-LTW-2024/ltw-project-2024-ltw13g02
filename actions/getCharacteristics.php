<?php
require_once('../database/connection.db.php');
require_once('../database/get_from_db.php');

$db = getDatabaseConnection();

$category = $_GET['categoryId'];
$types = getTypesofCategory($category);

$response = [];
foreach ($types as $type) {
    $characteristics = getCharacteristicsByType($db, $type['idType']);
    $response[] = [
        'idType' => $type['idType'],
        'type_name' => $type['type_name'],
        'characteristics' => $characteristics
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
