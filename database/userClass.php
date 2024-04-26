<?php
class User {
    public int $idUser;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public string $userAddress;
    public float $stars;
    public string $city;
    public int $idCountry;
    public string $zipCode;
    public ?string $photo;

    public function __construct(int $idUser, string $firstName, string $lastName, string $phone, string $email, string $userAddress, float $stars, string $city, int $idCountry, ?string $photo, string $zipCode) {
        $this->idUser = $idUser;
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

    function save($db) {
        $stmt = $db->prepare('
            UPDATE User SET FirstName = ?, LastName = ?
            WHERE idUser = ?
        ');

        $stmt->execute(array($this->firstName, $this->lastName, $this->idUser));
    }

    function getFavorites(PDO $db) : array {
        $stmt = $db->prepare('
            SELECT Favorites.product
            FROM Favorites
            WHERE Favorites.user = ?
        ');
        $stmt->execute(array($this->idUser));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    function getRecent(PDO $db) : array {
        $stmt = $db->prepare('
            SELECT Recent.product
            FROM Recent
            WHERE Recent.user = ?
        ');
        $stmt->execute(array($this->idUser));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function getShoppingCart(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT ShoppingCart.product
            FROM ShoppingCart
            WHERE ShoppingCart.user = ?
        ');
        $stmt->execute(array($id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function getChatsAsSeller(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT Product.prodName, User.firstName, USer.lastName
            FROM Product, Chat, User
            WHERE Product.seller = ?, Chat.product = Product.idProduct, Chat.possibleBuyer = User.idUser
        ');
        $stmt->execute(array($id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function getChatsAsBuyer(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT Product.prodName, User.firstName, USer.lastName
            FROM Product, Chat, User
            WHERE Product.seller = User.id, Chat.product = Product.idProduct, Chat.possibleBuyer = ?
        ');
        $stmt->execute(array($id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}