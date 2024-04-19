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

?>