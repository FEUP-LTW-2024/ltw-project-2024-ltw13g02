<?php
require_once(__DIR__ . '/connection.db.php');
require_once(__DIR__ . '/user.class.php');
require_once(__DIR__ . "/product.class.php");

require_once('connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
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
    if(count($reviews) === 0) return 0;
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


function getCategories() {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT C.category 
                        FROM Category C ");
    $stmt->execute();

    $categories = $stmt->fetchAll();
    return $categories;  

}

function getTypes() {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT type_name 
                        FROM TypesInCategory ");
    $stmt->execute();

    $types = $stmt->fetchAll();
    return $types;  

}

function getChat($idChat): ?Chat {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM Chat WHERE Chat.idChat = ?');
    $stmt->execute(array($idChat));
    $chat = $stmt->fetch();
    if ($chat) {
        return new Chat(
            $chat['idChat'],
            $chat['product'],
            $chat['possibleBuyer']
        );
    } else {
        return null;
    }
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

function getUserbyemail($email) : ?User {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('SELECT * FROM User WHERE User.email = ?');
    $stmt->execute(array($email));
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
    if ($session->isLoggedIn()) {
        $stmt = $db->prepare('SELECT P.idProduct
                            FROM Product P
                            WHERE P.seller != ? and P.buyer is null;');
        $stmt->execute(array( $user->getId()));
        $products_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $products_id;
    }else{
        $stmt = $db->prepare('SELECT P.idProduct
                            FROM Product P
                            Where P.buyer is null;
                            ');
        $stmt->execute();
        $products_id = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $products_id;
    }
}