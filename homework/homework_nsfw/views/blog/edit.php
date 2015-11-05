<?php
    $BlogsController = new BlogsController($db, $plural_resorce, $option);
    $blogs = $BlogsController->show();
    $blog = mysqli_fetch_assoc($blogs);
    $BlogsController->edit($_POST,$option);
?>

<form action="" method="post" accept-charset="utf-8">
  <label for="title">タイトル</label><br>
  <input type="text" name="title" <?php echo Make_value($blog['title']); ?>><br>
  <?php if(isset($_POST['title'])){
      if($_POST['title'] =='empty'){
    echo "<p>* タイトルを入力してください</p>";
    }
  }
  ?>
  <label for="body">本文</label><br>
  <textarea name="body"><?php echo $blog['body'] ?></textarea><br>
  <?php if(isset($_POST['body'])){
    if($_POST['body'] =='empty'){
      echo "<p>* 本文を入力してください</p>";
      }
    }
  ?>
  <a href="../index">一覧に戻る</a>｜<input type="submit" value="編集を終える">

</form>

