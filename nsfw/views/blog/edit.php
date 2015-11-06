<?php
    $BlogsController = new BlogsController($db, $plural_resorce);
    $blog = $BlogsController->edit($_POST,$id);
    var_dump($_POST);
?>

<div>
  <form action="" method="post">
    <div>
      <input type="text" name="title" value="<?php echo $blog['title'];?>">
    </div>
    <div><textarea name="body"><?php echo $blog['body']; ?></textarea></div>
    <div><input type="submit" value="編集完了"></div>
  </form>
</div>
