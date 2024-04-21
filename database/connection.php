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
    $stmt = $db->prepare('SELECT P.prodName, P.prodDescription, P.price 
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