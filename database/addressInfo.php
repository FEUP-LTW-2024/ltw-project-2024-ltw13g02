<?php

class ShippingAddressInfo {
    public string $country;
    public string $city;
    public string $address;
    public string $zipCode;

    public function __construct(string $country, string $city, string $address, string $zipCode) {
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->zipCode = $zipCode;
    }

    public function getFullAddress(): string {
        return $this->country .' '. $this->city . ', ' . $this->address . ', ' . $this->zipCode;
    }
}