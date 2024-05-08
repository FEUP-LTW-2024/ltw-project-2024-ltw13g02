<?php
require_once(__DIR__ . '/connection_to_db.php');
require_once(__DIR__ . '/userClass.php');
require_once(__DIR__ . "/productClass.php");

require_once('connection_to_db.php');
require_once(__DIR__ . '/../database/userClass.php');
require_once(__DIR__ . '/change_in_db.php');

function getUser($email, $password) : ?User{

    $db = getDatabaseConnection();
    $stmt = $db->prepare("
        SELECT idUser, firstName, lastName, phone, email, stars, photo, userPassword, idCountry, city, userAddress, zipCode
        FROM User 
        WHERE lower(email) = ?"
    );
    $stmt->execute(array(strtolower($email)));
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['userPassword'])) {
        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['phone'],
            $user['email'],
            $user['userAddress'],
            $user['stars'],
            $user['city'],
            $user['idCountry'],
            $user['photo'],
            $user['zipCode'],
        );
    } else {
        return null;
    }
}
    
function getCountryFromDB($idCountry) : ?string {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT country FROM Country WHERE idCountry = ?');
    $stmt->execute(array($idCountry));
    $country = $stmt->fetch();
    return isset($country['country']) ? $country['country'] : null;
}

function getCategories($db){
    $stmt = $db->prepare("SELECT C.category 
                        FROM Category C ");
    $stmt->execute();
    $categories = $stmt->fetchAll();
    return $categories;  

}

function getLastMessage($idChat): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT * FROM Messages
        WHERE chat = ? 
        ORDER BY messageDate DESC
        LIMIT 1
    ');
    $stmt->execute(array($idChat));
    $lastmessage = $stmt->fetch();
    return $lastmessage;
}

function getMessages($idChat): ?array {
    
}

function getChatInfo($idChat): ?array {
    
}

function getProduct($idProduct) : ?Product {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM Product WHERE Product.idProduct = ?');
    $stmt->execute(array($idProduct));
    $product = $stmt->fetch();
    if ($product) {
        return new Product(
            $product['idProduct'],
            $product['prodName'],
            $product['price'],
            $product['condition'],
            $product['prodDescription'],
            $product['characteristic1'],
            $product['characteristic2'],
            $product['characteristic3'],
            $product['seller'],
            $product['buyer'],
            $product['purchaseDate']
        );
    } else {
        return null;
    }
}

function getUserbyId($idUser) : ?User {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM User WHERE User.idUser = ?');
    $stmt->execute(array($idUser));
    $user = $stmt->fetch();
    if ($user) {
        return new User(
            $user['idUser'],
            $user['firstName'],
            $user['lastName'],
            $user['phone'],
            $user['email'],
            $user['userAddress'],
            $user['stars'],
            $user['city'],
            $user['idCountry'],
            $user['photo'],
            $user['zipCode'],
        );
    } else {
        return null;
    }
}

function getAllCountries() {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT C.country 
                            FROM Country C');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function getRecommended() { 
    $db = getDatabaseConnection();
    $session = new Session();
    $user = $session->getUser();
    if (isset($currentId)) {
        $stmt = $db->prepare('SELECT P.idProduct
                            FROM Product P
                            WHERE P.seller != ?');
        $stmt->execute(array( $user->getId()) );
        $products_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $products_id;
    }else{
        $stmt = $db->prepare('SELECT P.idProduct
                            FROM Product P
                            ');
        $stmt->execute();
        $products_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $products_id;
    }
}