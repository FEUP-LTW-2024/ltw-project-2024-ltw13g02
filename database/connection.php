<?php

  function getDatabaseConnection() {
    return new PDO('sqlite:basededados.db');
  }

  function getAllUsers($db) {
    $stmt = $db->prepare('SELECT firstName, lastName
                          FROM User
                          ORDER BY firstName, lastName ASC;
                        ');

    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getUserShopingCart( $db, $user_id ) {
    $stmt = $db->prepare('SELECT *
                          FROM Product P JOIN ShoppingCart S ON P.idProduct = S.product 
                          WHERE S.user = ? ');
    $stmt->execute(array( $_SESSION['idUser']) );
    $result = $stmt->fetchAll();
    return $result;
  }

  function getUserAddress( $db, $user_id ) {
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

  function getUserPublicInfo($db, $user_id){
    $stmt = $db->prepare('SELECT U.idUser, U.firstName, U.lastName, U.stars 
                          FROM User U
                          WHERE U.idUser = ?');
    $stmt->execute(array( $user_id) );
    $result = $stmt->fetch();
    return $result;
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
    $result = $stmt->fetchAll();
    return $result;
  }

