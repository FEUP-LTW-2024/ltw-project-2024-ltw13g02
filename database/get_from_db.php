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

function getStarsFromReviews($idUser): ?float {
    $reviews = getReviewsFromDB($idUser);
    $sum = 0;
    if(count($reviews) == 0) return 0;
    for ($i = 0; $i < count($reviews); $i++) {
        $sum += $reviews[$i]['stars'];
    }
    $average = $sum / count($reviews);

    $db = getDatabaseConnection();
    $stmt = $db->prepare("UPDATE User SET stars = ? WHERE idUser = ?");
    $stmt->execute(array($average, $idUser));

    return $average;
}

function getReviewsFromDB($idUser): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT stars, reviewsDescription FROM Reviews WHERE idUser = ?");
    $stmt->execute(array($idUser));
    $reviews = $stmt->fetchAll();
    return $reviews;
}

function getReviewsWithUsersFromDB($idUser): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT U.firstName, U.lastName, R.* FROM Reviews R 
    LEFT JOIN User U ON R.idUserFrom = U.idUser
    WHERE R.idUser = ?");
    $stmt->execute(array($idUser));
    $reviews = $stmt->fetchAll();
    return $reviews;
}

function getCategories($db){
    $stmt = $db->prepare("SELECT C.category 
                        FROM Category C ");
    $stmt->execute();
    $categories = $stmt->fetchAll();
    return $categories;  

}

function getChatsAsSellerFromDB($idUser): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT idChat,  Product.idProduct, Product.prodName, User.firstName, User.lastName
        FROM Product, Chat, User
        WHERE Product.seller = ? AND Chat.product = Product.idProduct AND Chat.possibleBuyer = User.idUser
    ');
    $stmt->execute(array($idUser));
    $chats = $stmt->fetchAll();
    return $chats;
}

function getChatsAsBuyerFromDB($idUser): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT idChat, Product.idProduct, Product.prodName, User.firstName, User.lastName
        FROM Product, Chat, User
        WHERE Product.seller = User.idUser AND Chat.product = Product.idProduct AND Chat.possibleBuyer = ?
    ');
    $stmt->execute(array($idUser));
    $reviews = $stmt->fetchAll();
    return $reviews;
}

function getPhotos($idProduct): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT photo
        FROM Photo
        WHERE Photo.idProduct = ?
    ');
    $stmt->execute(array($idProduct));
    $photos = $stmt->fetchAll();
    return $photos;
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
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT * FROM Messages
        WHERE chat = ? 
        ORDER BY messageDate DESC
    ');
    $stmt->execute(array($idChat));
    $messages = $stmt->fetchAll();
    return $messages;
}

function getChatInfo($idChat): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT Product.idProduct, Product.prodName as ProdName, Seller.idUser as SId, Seller.firstName as SFN, Seller.lastName as SLN, Seller.photo as SP, Buyer.idUser as BId, Buyer.firstName as BFN, Buyer.lastName as BLN, Buyer.photo as BP
        FROM Product, Chat, User as Seller, User as Buyer
        WHERE idChat = ? AND Chat.product = Product.idProduct AND Chat.possibleBuyer = Buyer.idUser AND Product.seller = Seller.idUser
    ');
    $stmt->execute(array($idChat));
    $info = $stmt->fetch();
    return $info;
}

function getProduct($idProduct) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM Product WHERE Product.idProduct = ?');
    $stmt->execute(array($idProduct));
    $product = $stmt->fetch();
    return $product;
}

function getUserbyId($idUser) {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM User WHERE User.idUser = ?');
    $stmt->execute(array($idUser));
    $product = $stmt->fetch();
    return $product;
}

function getAllUsers($db) {
    $stmt = $db->prepare('SELECT firstName, lastName
                            FROM User
                            ORDER BY firstName, lastName ASC;
                        ');

    $stmt->execute();
    return $stmt->fetchAll();
}

function getUserShopingCart( $db, $user_id ) {
    $stmt = $db->prepare('SELECT S.product
                            FROM Product P JOIN ShoppingCart S ON P.idProduct = S.product 
                            WHERE S.user = ? ');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetchAll();
    return $result;
}

function getUserAddress( $db, User $user_id ) {
    $stmt = $db->prepare('SELECT U.userAddress, U.city, C.country, U.zipCode
                            FROM User U JOIN Country C ON C.idCountry = U.idCountry
                            WHERE U.idUser = ? ');
    $stmt->execute(array( $_SESSION['idUser']) );
    $result = $stmt->fetch();
    return $result;
}

function getAllCountries( $db ) {
    $stmt = $db->prepare('SELECT C.country 
                            FROM Country C');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}

function get_product( $db, $product_id ) {
    $stmt = $db->prepare('SELECT *
                            FROM Product p
                            WHERE P.idProduct = ?');
    $stmt->execute(array( $product_id) );
    $result = $stmt->fetch();
    return $result;
}

function getUserInfo($db, $idUser) : ?User{
    $stmt = $db->prepare('SELECT * 
                            FROM User U
                            WHERE U.idUser = ?');
    $stmt->execute(array( $idUser) );
    $result = $stmt->fetch();
    if ( empty($result) ) {return null;}
    $user = new User($result['idUser'], $result['firstName'], $result['lastName'], $result['phone'], $result['email'],
                        $result['userAddress'], $result['stars'], $result['city'], $result['idCountry'], $result['photo'], $result['zipCode']);
    return $user;
}

function get_user_num_reviews($db, $user_id) {
    $stmt = $db->prepare('SELECT COUNT(*) as num_reviews
                            FROM  Reviews R
                            WHERE R.idUser = ?');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetch();
    return $result['num_reviews'];
}

function get_seller_products($db, $idSeller) {
    $stmt = $db->prepare('SELECT *
                            FROM Product P
                            WHERE P.seller = ? AND P.buyer is NULL');
    $stmt->execute(array( $idSeller) );
    $result = $stmt->fetchAll();
    return $result;
}

function get_archive_products($db, $idUser){
    $stmt = $db->prepare('SELECT *
                            FROM Product P
                            WHERE P.seller = ? AND P.buyer IS NOT NULL');
    $stmt->execute(array( $idUser) );
    $products = $stmt->fetchAll();
    return $products;
}

function build_Product_from_id($db, $id) {
    $stmt = $db->prepare('SELECT *
                            FROM Product P
                            WHERE P.idProduct = ?');
    $stmt->execute(array( $id) );
    $product = $stmt->fetch();
    $result = new Product($product['idProduct'], $product['prodName'], $product['price'], $product['condition'],
                            $product['characteristic1'],$product['characteristic2'],$product['characteristic3'],
                            $product['seller'], $product['buyer'], $product['purchaseDate']);
    return $result;

}

function getRecommended( $db ) {
    $session = new Session();
    $currentId = $session->getId();
    if (isset($currentId)) {
        $stmt = $db->prepare('SELECT P.idProduct
                            FROM Product P
                            WHERE P.seller != ?');
        $stmt->execute(array( $currentId) );
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