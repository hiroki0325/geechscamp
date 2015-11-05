<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>nsfw - シンプルフレームワーク</title>
</head>
<body>
  <h1>Blogシステム</h1>
  <?php
      // require()関数と同じく、指定したパスのファイルを読み込む
      include('./views/' . $resource . '/' . $action . '.php');
      // URLが /blog/indexの場合
      // ./views/blog/index.php
   ?>
</body>
</html>
