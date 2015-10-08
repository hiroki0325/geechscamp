<?php
    // var_dump($_POST);
    $nickname = $_POST["nickname"];
    $comment = $_POST["comment"];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アンサー</title>
</head>
<body>
  <h1>掲示板</h1>
  <ul>
    <li><?php echo $nickname; ?> ： <?php echo $comment ?></li>
  </ul>
  <a href="post_sample.php">つぶやき画面へ</a>
</body>
</html>
