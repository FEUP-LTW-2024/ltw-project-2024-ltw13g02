<?php
require_once(__DIR__ . '/chat.class.php');
require_once(__DIR__ . '/../database/connection.db.php');


class User {
    public string $id;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public string $userAddress;
    public float $stars;
    public string $city;
    public int $idCountry;
    public string $zipCode;
    public string $photo;

    public function __construct(string $id, string $firstName, string $lastName, string $phone, string $email, string $userAddress, float $stars, string $city, int $idCountry, string $photo, string $zipCode) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->userAddress = $userAddress;
        $this->stars = $stars;
        $this->city = $city;
        $this->idCountry = $idCountry;
        $this->photo = $photo;
        $this->zipCode = $zipCode;
    }

    function name(): string {
        return $this->firstName . ' ' . $this->lastName;
    }

    function getCountry() : ?string {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT country FROM Country WHERE idCountry = ?');
        $stmt->execute(array($this->idCountry));
        $country = $stmt->fetch();
        return isset($country['country']) ? $country['country'] : null;
    }

    function isAdmin() : bool {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT UserAdmin.idUser
            FROM UserAdmin
            WHERE UserAdmin.idUser = ?
        ');
        $stmt->execute(array($this->id));
        $admin = $stmt->fetch();
        if ($admin) {
            return true;
        }
        else return false;
    }

    function getFavorites() : ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT Favorites.product
            FROM Favorites
            WHERE Favorites.user = ?
        ');
        $stmt->execute(array($this->id));
        $favs = $stmt->fetchAll(PDO::FETCH_COLUMN);
        if (count($favs) > 0) {
            return $favs;
        }
        else return null;
    }

    function isFavorite($idProduct) : bool {
        $favs = $this->getFavorites();
        foreach ($favs as $f) {
            if ($f['product'] == $idProduct) return true;
        }
        return false;
    }

    function addToRecents($idProduct) {
        $db = getDatabaseConnection();
        $recents = $this->getRecent();


        foreach ($recents as $recent) {
            if ($recent == $idProduct) {
                $stmt = $db->prepare('DELETE FROM Recent WHERE Recent.user = ? AND Recent.product = ?');
                $stmt->execute(array($this->id, $idProduct));
            }
        }
        $recents = $this->getRecent();
        if (count($recents) > 4) {
            for ($i = 4; $i < count($recents); $i++) {
                $stmt = $db->prepare('DELETE FROM Recent WHERE Recent.user = ? AND Recent.product = ?');
                $stmt->execute(array($this->id, $recents[$i]));
            }
        }
        $stmt = $db->prepare('INSERT INTO Recent(user, product) VALUES (?, ?)');
        $stmt->execute(array($this->id, $idProduct));
    }

    function getRecent() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT Recent.product
            FROM Recent
            WHERE Recent.user = ?
        ');
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($result)) {
            return [];
        }

        for ($i = 0; $i < count($result); $i++) {
            $final[$i] = $result[count($result) - 1 - $i];
        }

        return $final;
    }

    function getShoppingCart() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT ShoppingCart.product
            FROM ShoppingCart
            WHERE ShoppingCart.user = ?
        ');
        $stmt->execute(array($this->id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function getAnnouncements() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT idProduct
            FROM Product
            WHERE seller = ? 
            AND buyer IS NULL
        ');
        $stmt->execute(array($this->id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function getArchive() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT idProduct
            FROM Product
            WHERE seller = ? 
            AND buyer IS NOT NULL
        ');
        $stmt->execute(array($this->id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function getReviewsFromDB(): ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("SELECT stars, reviewsDescription FROM Reviews WHERE idUser = ?");
        $stmt->execute(array($this->id));
        $reviews = $stmt->fetchAll();
        return $reviews;
    }

    function getNumberOfReviews() {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT COUNT(*) as num_reviews
                                FROM  Reviews R
                                WHERE R.idUser = ?');
        $stmt->execute(array($this->id) );
        $result = $stmt->fetch();
        return $result['num_reviews'];
    }

    function getSellingProducts() {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT P.idProduct
                                FROM Product P
                                WHERE P.seller = ? AND P.buyer is NULL');
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    function getArchiveProducts() {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT *
                                FROM Product P
                                WHERE P.seller = ? AND P.buyer IS NOT NULL');
        $stmt->execute(array($this->id) );
        $products = $stmt->fetchAll();
        return $products;
    }

    function getStarsFromReviews(): ?float {
        $reviews = $this->getReviewsFromDB();
        $sum = 0;
        if(count($reviews) === 0) return 0;
        for ($i = 0; $i < count($reviews); $i++) {
            $sum += $reviews[$i]['stars'];
        }
        $average = $sum / count($reviews);
    
        $db = getDatabaseConnection();
        $stmt = $db->prepare("UPDATE User SET stars = ? WHERE idUser = ?");
        $stmt->execute(array($average, $this->id));
    
        return $average;
    }

    function getReviewsWithUsersFromDB(): ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("SELECT U.firstName, U.lastName, R.* FROM Reviews R 
        LEFT JOIN User U ON R.idUserFrom = U.idUser
        WHERE R.idUser = ?
        ORDER BY R.stars DESC;");
        $stmt->execute(array($this->id));
        $reviews = $stmt->fetchAll();
        return $reviews;
    }

    function getChatsAsSellerFromDB(): ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT idChat,  Product.idProduct, Product.prodName
            FROM Product, Chat
            WHERE Product.seller = ? AND Chat.product = Product.idProduct
        ');
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll();
        $chats = [];

        foreach ($result as $data) {
            if ($data['idChat'] != NULL) {
                $chats[] = new Chat($data["idChat"], $data["idProduct"], $data["prodName"]);
            }
        }

        return $chats;
    }
    function getChatsAsBuyerFromDB(): ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT idChat, Product.idProduct, Chat.possibleBuyer
            FROM Product, Chat
            WHERE Chat.product = Product.idProduct AND Chat.possibleBuyer = ?
        ');
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll();
        $chats = [];
        foreach ($result as $data) {
            $chat = new Chat($data["idChat"], $data["idProduct"], $data["possibleBuyer"]);
            if ($chat->getMessages() === []) {$chat->deleteChat();}
            else {$chats[] = $chat;}
        }

        return $chats;
    }

    function findBuyerChat($idProduct): Chat {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT idChat, Chat.possibleBuyer
            FROM Chat
            WHERE Chat.product = ? AND Chat.possibleBuyer = ?
        ');
        $stmt->execute(array($idProduct, $this->id));
        $result = $stmt->fetch();
        if ($result) {
            return new Chat($result["idChat"], $idProduct, $result["possibleBuyer"]);
        }
        else {
            $this->addChat($idProduct);
            $db = getDatabaseConnection();
            $stmt = $db->prepare('
                SELECT idChat, Chat.possibleBuyer
                FROM Chat
                WHERE Chat.product = ? AND Chat.possibleBuyer = ?
            ');
            $stmt->execute(array($idProduct, $this->id));
            $result = $stmt->fetch();
            return new Chat($result["idChat"], $idProduct, $result["possibleBuyer"]);
        };
    }

    function addChat($idProduct) {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            INSERT INTO Chat(product, possibleBuyer)
            VALUES (?, ?)
        ');
        $stmt->execute(array($idProduct, $this->id));
    }

    function addToFavorites($idProduct) {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            INSERT INTO Favorites(user, product)
            VALUES (?, ?)
        ');
        $stmt->execute(array($this->id, $idProduct));
    }

    function removeFromFavorites($idProduct) {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            DELETE FROM Favorites
            WHERE user=? AND product=?
        ');
        $stmt->execute(array($this->id, $idProduct));
    }

    function getShippings() :array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("  SELECT S.idShipping
                                FROM Shipping S
                                WHERE S.seller = ?");
        $stmt->execute(array($this->id));
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }


    function deleteUser() {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('DELETE FROM User WHERE idUser=:idUser');
        $stmt->bindParam(':idUser', $this->id);
        $stmt->execute();
    }
}