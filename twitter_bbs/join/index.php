<?php
    session_start();

    // htmlspecialcharsのショートカット
    function h($value) {
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    // empty関数
    //// 空だったらtrueを返す
    //// isset関数の逆バージョン
    // !の機能
    //// 関数等の前に付けてif文の条件に入れるとtrueもしくはfalseを逆に変換します
    if (!empty($_POST)) {
      // エラー項目の確認
      if ($_POST["nickname"] == '') {
        $error["nickname"] = 'blank';
      }
      if ($_POST["email"] == '') {
        $error["email"] = 'blank';
      }

      // strlen関数
      //// 文字の長さを検証する関数
      if (strlen($_POST["password"]) < 4) {
        $error["password"] = 'lengh';
      }

      if ($_POST["password"] == '') {
        $error["password"] = 'blank';
      }

      if (empty($error)) {
        $_SESSION["join"] = $_POST;

        header('Location: check.php');
        exit();
      }

    }

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Cebu twitter</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
</head>
<body>
  <h1>Cebu twitter</h1>
  <p>次のフォームに必要事項をご記入ください。</p>

  <form action="" method="post" enctype="multipart/form-data">
    <div>
      <label for="">ニックネーム</label>
      <?php
          if (isset($_POST["nickname"])) {
            echo sprintf('<input type="text" name="nickname" value="%s">',
            // htmlspecialchars($_POST["nickname"], ENT_QUOTES, 'UTF-8')
            h($_POST["nickname"])
            ) ;
          } else {
            echo '<input type="text" name="nickname" >' ;
          }
      ?>
      <?php if (isset($error["nickname"])):?>
        <?php if ($error["nickname"] == 'blank' ): ?>
        <p class="error">* ニックネームを入力してください。</p>
     <?php endif; ?>
    <?php endif; ?>

    </div>

    <div>
      <label for="">メールアドレス</label>
      <input type="text" name="email">
    </div, ENT_QUOTES, 'UTF-8'>
    <div>
      <label for="">パスワード</label>
      <input type="password" name="password">
    </div>

    <div>
      <label for="">プロフィール画像</label>
      <input type="file" name="image">
    </div>

    <button type="submit">入力内容の確認</button>

  </form>

</body>
</html>
