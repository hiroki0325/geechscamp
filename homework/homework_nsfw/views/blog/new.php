<?php

    // BlogsControllerのshowを呼び出す
    $BlogsController = new BlogsController($db, $plural_resorce, $option);
    $blogs = $BlogsController->_new();

    echo "hallo world new view <br>";
    echo "<br>";

?>

<form action="" method="post" accept-charset="utf-8">
  <label for="title">タイトル</label><br>
  <input type="text" name="title" value=""><br>
  <?php if(isset($_POST['title'])){
      if($_POST['title'] =='empty'){
    echo "<p>* タイトルを入力してください</p>";
    }
  }
  ?>
  <label for="body">本文</label><br>
  <textarea name="body" cols="25" rows="5"></textarea><br>
  <?php if(isset($_POST['body'])){
    if($_POST['body'] =='empty'){
      echo "<p>* 本文を入力してください</p>";
      }
    }
  ?>
  <input type="submit" value="送信する">

</form>
