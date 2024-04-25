<?php
  require_once('templates/comments.php');
?>

<?php function output_article_list($articles) { ?>
  <section id="news">
    <?php foreach($articles as $article) output_article($article); ?>
  </section>
<?php } ?>

<?php function output_single_article($article, $comments) { ?>
  <section id="news">
    <?php output_article($article, $comments); ?>
  </section>
<?php } ?>

<?php function output_article($article, $comments = null) { 
  $tags = explode(',', $article['tags']);
  $date = date('F j', $article['published']); 
  $paragraphs = explode("\n\n", $article['fulltext']); ?>
  <article>
    <header>
      <h1><a href="article.php?id=<?=$article['id']?>"><?=$article['title']?></a></h1>
    </header>
    <img src="https://picsum.photos/600/300?<?=$article['id']?>" alt="">
    <p><?=$article['introduction']?></p>
    <?php 
      if (isset($comments)) {
        foreach ($paragraphs as $paragraph) { ?>
          <p><?=$paragraph?></p>
    <?php } 
        output_article_comments($comments);
      } ?>
    <footer>
      <span class="author"><?=$article['name']?></span>
      <span class="tags">
        <?php foreach ($tags as $tag) { ?>
          <a href="index.php">#<?=$tag?></a>
        <?php } ?>
      </span>
      <span class="date"><?=$date?></span>
      <a class="comments" href="article.php?id=<?=$article['id']?>#comments"><?=$article['comments']?></a>
    </footer>
  </article>
<?php } ?>