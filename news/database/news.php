<?php

  function getAllNews($db) {
    $stmt = $db->prepare('SELECT news.*, users.*, COUNT(comments.id) AS comments
                          FROM news JOIN
                              users USING (username) LEFT JOIN
                              comments ON comments.news_id = news.id
                          GROUP BY news.id, users.username
                          ORDER BY published DESC');

    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getNewsItem($db, $id) {
    $stmt = $db->prepare('SELECT * FROM news JOIN users USING (username) WHERE id = ?');
    $stmt->execute(array($id));
    return $stmt->fetch();
  }

?>