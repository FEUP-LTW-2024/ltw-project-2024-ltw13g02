<?php

class Product {
    public int $idProduct;
    public string $prodName;
    public int $price;
    public int $condition;
    public int $category;
    public string $description;
    public ?string $characteristic1;
    public ?string $characteristic2;
    public ?string $characteristic3;
    public string $seller;
    public ?int $buyer;
    public ?string $purchaseDate;

    public function __construct(int $idProduct, string $prodName, int $price, int $condition, string $description,
                                 ?string $characteristic1, ?string $characteristic2, ?string $characteristic3 , 
                                string $seller, ?int $buyer, ?string $purchaseDate) {
        $this->idProduct = $idProduct;
        $this->prodName = $prodName;
        $this->price = $price;
        $this->condition = $condition;
        $this->description = $description;
        $this->characteristic1 = $characteristic1;
        $this->characteristic2 = $characteristic2;
        $this->characteristic3 = $characteristic3;
        $this->seller = $seller;
        $this->buyer = $buyer;
        $this->purchaseDate = $purchaseDate;
    }

    function getId(): string {
        return $this->idProduct;
    }

    function getName(): string {
        return $this->prodName;
    }

    function getPrice(): string {
        return $this->price;
    }

    function getCondition(): string {
        return $this->condition;
    }

    function getDescription(): string {
        return $this->description;
    }

    function getCharacteristics(): array {
        $db = getDatabaseConnection();
        $characteristics = [];
    
        if ($this->characteristic1 !== null) {
            $stmt = $db->prepare('
                SELECT Characteristic.characteristic
                FROM Characteristic
                JOIN Product ON Characteristic.idCharacteristic = Product.characteristic1
                WHERE Product.idProduct = ?
            ');
            $stmt->execute([$this->idProduct]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $characteristics[] = $result['characteristic'];
            }
        }
    
        if ($this->characteristic2 !== null) {
            $stmt = $db->prepare('
                SELECT Characteristic.characteristic
                FROM Characteristic
                JOIN Product ON Characteristic.idCharacteristic = Product.characteristic2
                WHERE Product.idProduct = ?
            ');
            $stmt->execute([$this->idProduct]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $characteristics[] = $result['characteristic'];
            }
        }
    
        if ($this->characteristic3 !== null) {
            $stmt = $db->prepare('
                SELECT Characteristic.characteristic
                FROM Characteristic
                JOIN Product ON Characteristic.idCharacteristic = Product.characteristic3
                WHERE Product.idProduct = ?
            ');
            $stmt->execute([$this->idProduct]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $characteristics[] = $result['characteristic'];
            }
        }
        
        return $characteristics;
    }
    

    function getCategory() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
                SELECT Category.category
                FROM Characteristic, Category, TypesInCategory, Product
                WHERE Product.idProduct = 1 AND Product.characteristic1 = Characteristic.idCharacteristic AND Characteristic.idType = TypesInCategory.idType AND TypesInCategory.category = Category.idCategory
            ');
        $stmt->execute([$this->idProduct]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getPurchaseDate(): string {
        return $this->purchaseDate;
    }

    function getBuyer() : array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT firstName, lastName, stars, country, city
            FROM Product
            INNER JOIN User ON Product.buyer = User.idUser
            INNER JOIN Country ON User.idCountry = Country.idCountry
            WHERE Product.idProduct = ?
        ');
        $stmt->execute(array($this->buyer));

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getSeller() : ?User {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('SELECT * FROM User WHERE User.idUser = ?');
        $stmt->execute(array($this->seller));
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

    function getPhotos(): ?array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare('
            SELECT photo
            FROM Photo
            WHERE Photo.idProduct = ?
        ');
        $stmt->execute(array($this->idProduct));
        $photos = $stmt->fetchAll();
        return $photos;
    }

}