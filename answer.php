<?php
    ////DBへの接続
    $db = mysqli_connect('localhost','root','mysql','test_db') or die(mysqli_connect_error());
    mysqli_set_charset($db,'utf8');

    //情報が送られた時のみ、情報をDBに送る
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    // var_dump($_POST);
    $nickname = $_POST["nickname"];
    $comment = $_POST["comment"];

    //データの挿入
    // $sql = 'INSERT INTO posts (nickname,comment,created) VALUE("$nickname","$comment",NOW())';
    $sql = sprintf('INSERT INTO posts (nickname,comment,created) VALUE("%s","%s",NOW())',
                                $nickname,
                                $comment
                           );
    mysqli_query($db,$sql) ;
    }
?>

<?php
    //データの取得
    $sql = 'SELECT * FROM posts ORDER BY `created` DESC'; //逆シングルクオート
    $posts = mysqli_query($db,$sql) or die(mysqli_error($db));
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
    <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
      <li><?php echo $post["nickname"] ;?>：
            <?php echo $post["comment"] ; ?> -
            <?php echo $post["created"] ;?></li>
    <?php endwhile; ?>
  </ul>
  <a href="post_sample.php">つぶやき画面へ</a>
</body>
</html>
