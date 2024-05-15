<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/get_from_db.php');
require_once(__DIR__ . '/../database/user.class.php');


class Shipping {
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
}