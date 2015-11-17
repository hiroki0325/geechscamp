<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>NexSeedLink</title>
</head>
<body>
  <h1>NexSeedLink</h1>
  <?php
      // require()関数と同じく、指定したパスのファイルを読み込む
      include('./views/' . $function . '/' . $directry .  '/' . $page . '.php');
   ?>
</body>
</html>
