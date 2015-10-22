<?php
    session_start();
    require('../dbconnect.php');

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

      // エラー項目の確認//
      if ($_POST["nickname"] == '') {
        $error["nickname"] = 'blank';
      }
      if ($_POST["email"] == '') {
        $error["email"] = 'blank';
      }

      // strlen関数
      //// 文字の長さを検証する関数
      if (strlen($_POST["password"]) < 4) {
        $error["password"] = 'length';
      }

      if ($_POST["password"] == '') {
        $error["password"] = 'blank';
      }

      $fileName = $_FILES["image"]["name"];
      if (!empty($fileName)){
        // substr関数
        // 第一引数に入れた文字列から第二引数に入れた文字数から始まる文字を取得
        $ext = substr($fileName, -3);
          if ($ext != 'jpg' && $ext != 'gif') {
              $error["image"] = "type";
          }
      }

      // 重複アカウントチェック
      if(empty($error)) {
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
          mysqli_real_escape_string($db,$_POST['email'])
          );
        $record = mysqli_query($db,$sql) or die(mysqli_error($db));
        $table = mysqli_fetch_assoc($record);
        if($table['cnt'] > 0) {
          $error['email'] = 'duplicate';
        }
      }

      ////////////////////////////////


      // エラーがなければ次のページに行くための処理
      if (empty($error)) {
        // 画像アップロード
        $image = date('YmdHis') . $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], '../member_picture/'.$image);

        $_SESSION["join"] = $_POST;
        $_SESSION["join"] ["image"]= $image;

        header('Location: check.php');
        exit();
      }

    }

    // 書き直し処理
    if (isset($_REQUEST['action'])) {
        if($_REQUEST['action'] == 'rewrite'){
            $_POST = $_SESSION['join'];
            $error['rewrite'] = true;
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
      <?php
          if (isset($_POST["email"])) {
            echo sprintf('<input type="text" name="email" value="%s">',
               h($_POST["email"])
               );
          } else {
            echo '<input type="text" name="email">';
          }
       ?>
       <?php if (isset($error["email"])): ?>
            <?php if ($error["email"] == 'blank'): ?>
                <p class="error">* メールアドレスを入力してください</p>
            <?php endif ;?>
            <?php if ($error['email'] == 'duplicate'): ?>
            <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div>
      <label for="">パスワード</label>
      <?php
          if (isset($_POST["password"])) {
            echo sprintf('<input type="password" name="password" value="%s">',
               h($_POST["password"])
               );
          } else {
            echo '<input type="password" name="password">';
          }
       ?>
       <?php if (isset($error["password"])): ?>
            <?php if ($error["password"] == 'blank'): ?>
                <p class="error">* パスワードを入力してください</p>
            <?php endif ;?>
            <?php if ($error["password"] == 'length'): ?>
                <p class="error">* パスワードは4文字以上で入力してください</p>
            <?php endif ;?>
        <?php endif; ?>

    </div>

    <div>
      <label for="">プロフィール画像</label>
      <?php if (isset($error["image"])): ?>
           <?php if ($error["image"] == 'type'): ?>
               <p class="error">* 画像形式はjpgもしくはgifを指定してください。</p>
           <?php endif ;?>
       <?php endif; ?>
       <?php if (!empty($error)): ?>
           <p class="error">* 恐れ入りますが、画像を改めて指定してください。</p>
       <?php endif ;?>

      <input type="file" name="image">
    </div>

    <button type="submit">入力内容の確認</button>

  </form>

</body>
</html>
