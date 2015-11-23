<?php
    $BlogsController = new BlogsController($db, $plural_resorce);
    $BlogsController->_new($_POST);
?>

<div>
  <form action="" method="post">
    <div>
      <input type="text" name="title">
    </div>
    <div>
      <textarea name="body"></textarea>
    </div>
    <div>
      <input type="submit" value="記事投稿">
    </div>
  </form>
</div>
