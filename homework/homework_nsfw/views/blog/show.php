<?php
    // BlogsControllerのshowを呼び出す
    $BlogsController = new BlogsController($db, $plural_resorce, $option);
    $blogs = $BlogsController->show();

    echo "hallo world show view <br>";
    echo "<br>";

    while ($blog = mysqli_fetch_assoc($blogs)) {
      $title = $blog['title'];
      $body = $blog['body'];
      $created = $blog['created'];

      // 処理したデータ等を表示する(view)
      echo "====================<br>";
      echo $title;
      echo "<br>";
      echo $body;
      echo "<br>";
      echo $created;
      echo "<br>";
    }

?>
