<?php
require_once('connection_to_db.php');
require_once(__DIR__ . '/../database/userClass.php');
require_once(__DIR__ . '/change_in_db.php');


function getUser($email, $password) : ?User{

    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT idUser, firstName, lastName, phone, email, stars, photo, userPassword, idCountry, city, userAddress, zipCode
        FROM User 
        WHERE lower(email) = ?
    ');

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

function getStarsFromReviews($idUser): ?int {
    $db = getDatabaseConnection();
    $stmt = $db->prepare('
        SELECT SUM(R.stars) as S, COUNT(*) as C
        FROM USER U
        LEFT JOIN Reviews R ON U.idUser = R.idUser
        WHERE U.idUser = ?
        GROUP BY U.idUser
    ');
    $stmt->execute(array($idUser));
    $star = $stmt->fetch(PDO::FETCH_ASSOC);
    if (isset($star['S']) && isset($star['C'])) {
        setStarsOnDB($idUser, $star['S'] / $star['C']);
        return $star['S'] / $star['C'];
    }
    return null;
}

function getReviewsFromDB($idUser): ?array {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT stars, reviewsDescription FROM Reviews WHERE Reviews.idUser = ?");
    $stmt->execute(array($idUser));
    $reviews = $stmt->fetch(PDO::FETCH_ASSOC);
    return $reviews;
}