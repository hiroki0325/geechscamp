<?php
    require('dbconnect.php');

    session_start();
    if (isset($_COOKIE['email'])) {
        if ($_COOKIE['email'] != '') {
          $_POST['email'] = $_COOKIE['email'];
          $_POST['password'] = $_COOKIE['password'];
          $_POST['save'] = 'on';
        }
    }

    if (!empty($_POST)) {
      // ログインの処理
      if ($_POST['email'] != '' && $_POST['password'] != '') {
        // ユーザーがメールアドレスとパスワードを入力していれば処理をする

        // WHEREでmembersテーブルの中からメールアドレスとパスワード共に一致するデータがあるかをSELECT文で
        // 検索し、その結果を$sqlに格納
        $sql = sprintf('SELECT * FROM members WHERE email="%s" AND password="%s"',
            mysqli_real_escape_string($db, $_POST['email']),
            mysqli_real_escape_string($db, sha1($_POST['password']))
             );

        // クエリ関数に掛けた結果を$recordに格納
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));

        // $recordに格納されているデータを1件ずつ$tableに取り出してif文の中の処理を実行
        // この時、ユーザーは被らないデータとして一つしか存在しないので、
        // $record の中にも一致するひとつのユーザーのデータが入る
        if ($table = mysqli_fetch_assoc($record)) {
          // ログイン成功

          // ユーザーのidをセッションに格納
          $_SESSION['id'] = $table['id'];

          // ログインした時間をセッションに格納
          $_SESSION['time'] = time();

          // ログイン情報を記録する
          if ($_POST['save'] == 'on') {
            setcookie('email', $_POST['email'], time()+60*60*24*14);
            setcookie('password', $_POST['password'], time()+60*60*24*14);
          }

          header('Location: index.php');
          exit();
        } else {
          $error['login'] = 'failed';
        }

      } else{
        $error['login'] = 'blank';

      }
    }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>

<body>
  <h1>ログイン</h1>
  <p>&raquo;<a href="join/">入会手続きをする</a></p>
  <form action="" method="post">
    <div>
      <label for="">メールアドレス</label>
      <?php if (isset($_POST['email'])): ?>
      <input type="text" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>">
      <?php else: ?>
        <input type="text" name="email">
      <?php endif ?>

      <?php if (isset($error)): ?>
        <?php if ($error['login'] == 'blank'): ?>
          <p class="error">* メールアドレスとパスワードをご記入ください。</p>
        <?php endif; ?>
        <?php if ($error['login'] == 'failed'): ?>
          <p class="error">* ログインに失敗しました。正しく情報をご記入ください。</p>
        <?php endif; ?>
      <?php endif ?>
    </div>

    <div>
      <label for="">パスワード</label>
      <input type="password" name="password">
    </div>

    <p>ログイン情報の記録</p>
    <div>
      <input type="checkbox" id="save" name="save" value="on">
      <label for="">次回から自動でログインする</label>
    </div>

    <div>
      <input type="submit" value="ログインする">
    </div>

  </form>
</body>
</html>
