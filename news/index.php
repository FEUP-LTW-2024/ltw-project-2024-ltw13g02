<?php
  require_once('database/connection.php');
  require_once('database/news.php');

  require_once('templates/common.php');
  require_once('templates/news.php');

  $db = getDatabaseConnection();
  $articles = getAllNews($db);

  output_header();
  output_article_list($articles);
  output_footer();
?>