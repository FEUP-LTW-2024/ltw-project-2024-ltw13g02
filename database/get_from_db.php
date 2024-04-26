<?php
require_once(__DIR__ . '/connection_to_db.php');
require_once(__DIR__ . '/userClass.php');

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
    $country = $stmt->fetch(PDO::FETCH_ASSOC);
    return isset($country['country']) ? $country['country'] : null;
}

function getStarsFromReviews($idUser): ?float {
    $reviews = getReviewsFromDB($idUser);
    $sum = 0;
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