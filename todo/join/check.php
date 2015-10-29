<?php
    session_start();

    require('../dbconnect.php');
    require('../functionh.php');

    if (!isset($_SESSION["join"])) {
      header('Location: index.php');
      exit();
    }

    if (!empty($_POST)) {
      // 登録処理をする
      $sql = sprintf('INSERT INTO users SET name="%s", mail="%s", password="%s", created=NOW()',
            mysqli_real_escape_string($db, $_SESSION['join']['name']),
            mysqli_real_escape_string($db, $_SESSION['join']['mail']),
            mysqli_real_escape_string($db, sha1($_SESSION['join']['password']))
            );
      mysqli_query($db, $sql) or die(mysqli_error($db));
      unset($_SESSION['join']);

      header('Location: thanks.php');
      exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>確認画面</title>
</head>
<body>
  <form action="" method="post">
    <input type="hidden" name="action" value="submit">
    <dl>
      <dt>ニックネーム</dt>
      <dd>
        <?php echo h($_SESSION['join']['name']); ?>
      </dd>
      <dt>メールアドレス</dt>
      <dd>
        <?php echo h($_SESSION['join']['mail']); ?>
      </dd>
      <dt>パスワード</dt>
      <dd>
        【表示されません】
      </dd>
    </dl>
    <div><a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>｜<input type="submit" value="登録する"></div>
  </form>
</body>
</html>
