<?php
    session_start();

    // もしindex.phpを経由せず直接check.phpにアクセスがあった場合の処理
    if (!isset($_SESSION["join"])) {
      header("Location: index.php");
      exit();
    }

    // htmlspecialcharsのショートカット
    function h($value) {
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebu twitter</title>
</head>
<body>
  <h1>入力内容確認画面</h1>

  <form action="" method="post">
    <div>
      <p>ニックネーム</p>
      <!-- 入力されたニックネームの値 -->
      <?php echo h($_SESSION["join"]["nickname"]); ?>
    </div>
    <div>
      <p>メールアドレス</p>
      <!-- 入力されたメールアドレスの値 -->
      <?php echo h($_SESSION["join"]["email"]); ?>
    </div>
    <div>
      <p>パスワード</p>
      <!-- 入力されたパスワードの値 -->
      【表示されません】
    </div>
    <div>
      <p>プロフィール画像</p>
      <!-- 選択された画像 -->
      <?php
          echo sprintf('<img src="../member_picture/%s" width="100" height="100">',
            $_SESSION["join"]["image"]
          );
       ?>
    </div>

    <div>
      <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a> |
      <input type="submit" value="登録する">
    </div>

  </form>

</body>
</html>
