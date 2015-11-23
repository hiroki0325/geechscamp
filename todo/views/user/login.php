<?php
    if (isset($_COOKIE['name'])) {
        if ($_COOKIE['name'] != '') {
          $_POST['name'] = $_COOKIE['name'];
          $_POST['password'] = $_COOKIE['password'];
          $_POST['save'] = 'on';
        }
    }


    if (!empty($_POST)) {
      # ログインの処理
      if ($_POST['name'] != '' && $_POST['password'] != '' ) {
        $sql = sprintf('SELECT * FROM users WHERE name="%s" AND password="%s"',
          mysqli_real_escape_string($db, $_POST['name']),
          mysqli_real_escape_string($db, sha1($_POST['password']))
          );
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
            if ($table = mysqli_fetch_assoc($record)) {
              // ログイン成功
              $_SESSION['id'] = $table['id'];
              $_SESSION['time'] = time();

              // ログイン情報を記録する
              if ($_POST['save'] == 'on') {
                setcookie('name', $_POST['name'], time()+60*60*24*14);
                setcookie('password', $_POST['password'], time()+60*60*24*14);
              }
              header('Location: ../task/index');
              exit();
            } else {
            $error['login'] = 'failed';
         }
      } else {
        $error{'login'} = 'blank';
      }
    }
 ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン画面</title>
</head>
<body>
  <div id="lead">
    <p>名前とパスワードを記入してログインしてください。</p>
    <p>入会手続きがまだの方はこちらからどうぞ。</p>
    <p>&raquo;<a href="new">入会手続きをする</a></p>
  </div>
  <form action="" method="post">
    <dl>
      <dt>ニックネーム</dt>
      <dd>
        <?php fillout("name") ?>
        <?php if (isset($error['login'])): ?>
            <?php if ($error['login'] == 'blank'): ?>
            <p class="error">* メールアドレスとパスワードをご記入ください</p>
            <?php endif; ?>
            <?php if($error['login'] == 'failed'): ?>
            <p class="error">* ログインに失敗しました。正しくご記入ください。</p>
            <?php endif; ?>
        <?php endif; ?>

      </dd>
      <dt>パスワード</dt>
      <dd>
        <?php if (isset($_POST['password'])): ?>
          <input type="password" name="password" size="35" value="<?php echo h($_POST['password']); ?>">
        <?php else: ?>
          <input type="password" name="password" size="35">
        <?php endif ?>
      </dd>
     <dt>ログイン情報の記録</dt>
      <dd>
        <input id="save" type="checkbox" name="save" value="on">
        <label for="save">次回からは自動的にログインする</label>
      </dd>
    </dl>
    <div>
      <input type="submit" value="ログインする">
    </div>
  </form>
</body>
</html>
