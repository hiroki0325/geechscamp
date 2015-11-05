<?php
    // BlogsControllerのindexを呼び出す
    $BlogsController = new BlogsController($db, $plural_resorce ,$option);
    $blogs = $BlogsController->index();

    echo "hallo world index view <br>";
    echo "<br>";

    while ($blog = mysqli_fetch_assoc($blogs)) {
      $id = $blog['id'];
      $title = $blog['title'];
      $created = $blog['created'];

      // 処理したデータ等を表示する(view)
      echo "====================<br>";
      echo $title;
      echo "<br>";
      echo $created;
      echo "<br>";
      echo '<a href="show/' . $id .'">詳細を見る</a>｜';
      echo '<a href="delete/' . $id .'">削除</a>';
      echo "<br>";
    }
    echo "====================";

?>
<br><br>
<h2><a href="new">新しい記事を作る</a></h2>
