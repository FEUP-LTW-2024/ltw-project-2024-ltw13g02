<?php

  require_once(__DIR__ . "/productClass.php");
  require_once(__DIR__ . "/userClass.php");

  function getAllUsers($db) {
    $stmt = $db->prepare('SELECT firstName, lastName
                          FROM User
                          ORDER BY firstName, lastName ASC;
                        ');

    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getUserShopingCart( $db, $user_id ) {
    $stmt = $db->prepare('SELECT S.product
                          FROM Product P JOIN ShoppingCart S ON P.idProduct = S.product 
                          WHERE S.user = ? ');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetchAll();
    return $result;
  }

  function getUserAddress( $db, User $user_id ) {
    $stmt = $db->prepare('SELECT U.userAddress, U.city, C.country, U.zipCode
                          FROM User U JOIN Country C ON C.idCountry = U.idCountry
                          WHERE U.idUser = ? ');
    $stmt->execute(array( $_SESSION['idUser']) );
    $result = $stmt->fetch();
    return $result;
  }

  function getAllCountries( $db ) {
    $stmt = $db->prepare('SELECT C.country 
                          FROM Country C');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }

  function get_product( $db, $product_id ) {
    $stmt = $db->prepare('SELECT *
                          FROM Product p
                          WHERE P.idProduct = ?');
    $stmt->execute(array( $product_id) );
    $result = $stmt->fetch();
    return $result;
  }

  function getUserInfo($db, $user_id) : ?User{
    $stmt = $db->prepare('SELECT * 
                          FROM User U
                          WHERE U.idUser = ?');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetch();
    if ( empty($result) ) {return null;}

    $user = new User($result['idUser'], $result['firstName'], $result['lastName'], $result['phone'], $result['email'],
                     $result['userAddress'], $result['stars'], $result['city'], $result['idCountry'], $result['photo'], $result['zipCode']);
    
    return $user;
  }

  function get_user_num_reviews($db, $user_id) {
    $stmt = $db->prepare('SELECT COUNT(*) as num_reviews
                          FROM  Reviews R
                          WHERE R.idUser = ?');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetch();
    return $result['num_reviews'];
  }

  function get_seller_products($db, $idSeller) {
    $stmt = $db->prepare('SELECT *
                          FROM Product P
                          WHERE P.seller = ? AND P.buyer is NULL');
    $stmt->execute(array( $idSeller) );
    $result = $stmt->fetchAll();
    return $result;
  }

  function get_archive_products($db, $idUser){
    $stmt = $db->prepare('SELECT *
                          FROM Product P
                          WHERE P.seller = ? AND P.buyer IS NOT NULL');
    $stmt->execute(array( $idUser) );
    $products = $stmt->fetchAll();
    return $products;
  }

  function build_Product_from_id($db, $id) {
    $stmt = $db->prepare('SELECT *
                          FROM Product P
                          WHERE P.idProduct = ?');
    $stmt->execute(array( $id) );
    $product = $stmt->fetch();
    $result = new Product($product['idProduct'], $product['prodName'], $product['price'], $product['condition'], $product['category'],
                          $product['prodsize'], $product['seller'], $product['buyer'], $product['purchaseDate']);

    return $result;

  }

