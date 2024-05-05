<?php
require_once(__DIR__ . "/../database/get_from_db.php");

  class Session {
    private array $messages;

    public function __construct() {
      session_start();

      $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
      unset($_SESSION['messages']);
    }

    public function isLoggedIn() : bool {
      return isset($_SESSION['id']);    
    }

    public function logout() {
      session_destroy();
    }

    public function getEmail() : ?string {
      return isset($_SESSION['email']) ? $_SESSION['email'] : null;
    }

    public function setEmail(string $email) {
      $_SESSION['email'] = $email;
    }

    public function setId(string $id) {
      $_SESSION['id'] = $id;
    }

     public function getId() : ?string {
      return isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function setFirstName(string $firstName) {
      $_SESSION['firstName'] = $firstName;
    }

    public function getFirstName() : ?string {
      return isset($_SESSION['firstName']) ? $_SESSION['firstName'] : null;
    }

    public function setLastName(string $firstName) {
      $_SESSION['lastName'] = $firstName;
    }

    public function setPhone(string $phoneNumber) {
      $_SESSION['phoneNumber'] = $phoneNumber;
    }

    public function setAddress(string $address) {
      $_SESSION['userAddress'] = $address;
    }

    public function setCity(string $city) {
      $_SESSION['city'] = $city;
    }

    public function setZipCode(string $zipCode) {
      $_SESSION['zipCode'] = $zipCode;
    }

    public function getLastName() : ?string {
      return isset($_SESSION['lastName']) ? $_SESSION['lastName'] : null;
    }

    public function addMessage(string $type, string $text) {
      $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages() {
      return $this->messages;
    }

    public function getStars() : ?float {
      return isset($_SESSION['stars']) ? $_SESSION['stars'] : null;
    }  

    public function setStars(float $stars) {
      if ($stars == 0) {
        $stars = getStarsFromReviews($this->getId());
      }
      $_SESSION['stars'] = $stars;
    }

    public function getPhotoUser() : ?string {
      return isset($_SESSION['photo']) ? $_SESSION['photo'] : null;
    }

    public function setPhotoUser(string $photo) {
      $_SESSION['photo'] = $photo;
    }

    public function getPhone() : ?string {
      return isset($_SESSION['phoneNumber']) ? $_SESSION['phoneNumber'] : null;
    }

    public function getCountry() : ?string {
        return getCountryFromDB($_SESSION['Country']);
    }
  
    public function getCity() : ?string {
      return isset($_SESSION['city']) ? $_SESSION['city'] : null;
    }

    public function getAddress() : ?string {
      return isset($_SESSION['userAddress']) ? $_SESSION['userAddress'] : null;
    }

    public function getZipCode() : ?string {
      return isset($_SESSION['zipCode']) ? $_SESSION['zipCode'] : null;
    }

    public function setCountry(int $idCountry) {
      $_SESSION['Country'] = $idCountry;
    }

    public function setPreviousPage($page) {
      $_SESSION['previous-page'] = $page;
    }

    public function getPreviousPage() : string {
      if(isset($_SESSION['previous-page'])) {
          $previousPage = $_SESSION['previous-page'];
      } else {
          $previousPage = "index.php";
      }
      return $previousPage;    
    }

    public function setCurrentPage($page) {
      $_SESSION['current-page'] = $page;
    }

    public function getCurrentPage() : string {
      if(isset($_SESSION['current-page'])) {
          $currentPage = $_SESSION['current-page'];
      }
      return $currentPage;    
    }
  }
