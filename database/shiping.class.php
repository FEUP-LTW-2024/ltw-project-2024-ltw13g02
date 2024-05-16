<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../database/user.class.php');


class Shipping {
    public $id;
    public User $buyer;
    public string $buyerCountry;
    public string $buyerCity;
    public string $buyerAddress;
    public string $buyerZipcode;

    public User $seller;
    public string $sellerCountry;
    public string $sellerCity;
    public string $sellerAddress;
    public string $sellerZipcode;

    public string $purchaseDate;
    public int $total;

    public function __construct(
        int $id,
        User $buyer,
        string $buyerCountry,
        string $buyerCity,
        string $buyerAddress,
        string $buyerZipcode,
        User $seller,
        string $sellerCountry,
        string $sellerCity,
        string $sellerAddress,
        string $sellerZipcode,
        string $purchaseDate,
        int $total
    ) {
        $this->id = $id;
        $this->buyer = $buyer;
        $this->buyerCountry = $buyerCountry;
        $this->buyerCity = $buyerCity;
        $this->buyerAddress = $buyerAddress;
        $this->buyerZipcode = $buyerZipcode;
        $this->seller = $seller;
        $this->sellerCountry = $sellerCountry;
        $this->sellerCity = $sellerCity;
        $this->sellerAddress = $sellerAddress;
        $this->sellerZipcode = $sellerZipcode;

        $this->purchaseDate = $purchaseDate;
        $this->total = $total;
    }


    public function getProducts(): array {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("SELECT P.idProduct
                                FROM Product P
                                WHERE P.shipping = ?");
        $stmt->execute(array($this->id));
        $products_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $result = [];
        foreach ($products_ids as $product_id) {
            $result[] = getProduct($product_id);
        }
        return $result;
    }

    public function drawSellerFullAddress(): String {
        return "{$this->sellerAddress} {$this->sellerZipcode}, {$this->sellerCity}, {$this->sellerCountry }" ;
    }

    public function drawBuyerFullAddress(): String {
        return "{$this->buyerAddress} {$this->buyerZipcode}, {$this->buyerCity}, {$this->buyerCountry }" ;
    }
}