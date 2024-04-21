<?php

class User {
    public int $idUser;
    public string $firstName;
    public string $lastName;
    public string $phone;
    public string $email;
    public string $address;
    public string $stars;
    public string $city;
    public string $idCountry;
    public string $zipCode;

    function name() {
        return $this->firstName . ' ' . $this->lastName;
    }

    function save($db) {
        $stmt = $db->prepare('
            UPDATE User SET FirstName = ?, LastName = ?
            WHERE idUser = ?
        ');

        $stmt->execute(array($this->firstName, $this->lastName, $this->idUser));
    }

    static function getCustomerWithPassword(PDO $db, string $email, string $password) : ?Customer {
        $stmt = $db->prepare('
            SELECT CustomerId, FirstName, LastName, Address, City, State, Country, PostalCode, Phone, Email
            FROM Customer 
            WHERE lower(email) = ? AND password = ?
        ');

        $stmt->execute(array(strtolower($email), sha1($password)));

        if ($customer = $stmt->fetch()) {
            return new Customer(
                $customer['CustomerId'],
                $customer['FirstName'],
                $customer['LastName'],
                $customer['Address'],
                $customer['City'],
                $customer['Stars'],
                $customer['Country'],
                $customer['ZipCode'],
                $customer['Phone'],
                $customer['Email']
            );
        } else return null;
    }

    static function getCustomer(PDO $db, int $id) : User {
        $stmt = $db->prepare('
            SELECT idUser, FirstName, LastName, Address, City, State, Country, PostalCode, Phone, Email
            FROM User 
            WHERE idUSer = ?
        ');

        $stmt->execute(array($id));
        $user = $stmt->fetch();

        return new User(
            $user['CustomerId'],
            $user['FirstName'],
            $user['LastName'],
            $user['Address'],
            $user['City'],
            $user['State'],
            $user['Country'],
            $user['PostalCode'],
            $user['Phone'],
            $user['Email']
        );
    }

    static function getFavorites(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT Favorites.product
            FROM Favorites
            WHERE Favorites.user = ?
        ');
        $stmt->execute(array($id));

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    static function getRecent(PDO $db, int $id) : array {
        $stmt = $db->prepare('
            SELECT Recent.product
            FROM Recent
            WHERE Recent.user = ?
        ');
        $stmt->execute(array($id));

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

    // TODO: getChats
}