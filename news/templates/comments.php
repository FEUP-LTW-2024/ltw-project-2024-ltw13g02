<?php function output_article_comments($comments) { ?>
  <section id="comments">
    <h1><?=count($comments)?> Comments</h1>
    <?php foreach ($comments as $comment) { ?>
    <article class="comment">
      <span class="user"><?=$comment['name']?></span>
      <span class="date"><?=date('F j H:m', $comment['published'])?></span>
      <p><?=$comment['text']?></p>
    </article>
    <?php } ?>
    <form>
      <h2>Add your voice...</h2>
      <label>Username 
        <input type="text" name="username">
      </label>
      <label>E-mail
        <input type="email" name="email">
      </label>
      <label>Comment
        <textarea name="comment"></textarea>            
      </label>
      <button formaction="#" formmethod="post">Reply</button>
    </form>
  </section>
<?php } ?>