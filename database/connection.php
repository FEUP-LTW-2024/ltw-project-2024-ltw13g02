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