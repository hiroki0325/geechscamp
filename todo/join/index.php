<?php
  session_start();
  require('../dbconnect.php');
  require('../functionh.php');

  if (!empty($_POST)) {
    // エラー項目の確認
    if ($_POST['name'] =='') {
      $error['name'] = 'blank' ;
    }
    if ($_POST['mail']=='') {
      $error['mail'] = 'blank' ;
    }
    if (strlen($_POST['password']) < 4 ) {
      $error['password'] = 'length' ;
    }
    if ($_POST['password'] =='') {
      $error['password'] = 'blank' ;
    }
    if ($_POST['password'] != $_POST['password2']) {
      $error['password'] = 'notsame' ;
    }

    // 重複アカウントのチェック
    if (!empty($_POST)) {
      if (empty($error)) {
        $sql = sprintf('SELECT COUNT(*) AS cnt FROM users WHERE mail="%s"',
          mysqli_real_escape_string($db, $_POST["mail"])
          );
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table = mysqli_fetch_assoc($record);
        if ($table['cnt'] > 0 ){
          $error['mail'] = 'duplicate';
        }
      }
    }

    if (empty($error)) {
      $_SESSION['join'] = $_POST ;
      header('Location: check.php');
      exit();
    }
  }

  // 書き直し
  if (!empty($_SESSION['join'])) {
    if (!empty($_REQUEST['action'])) {
      if ($_REQUEST['action'] == 'rewrite') {
        $_POST = $_SESSION['join'];
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>会員登録</title>
</head>
<body>
  <p>次のフォームに必要事項をご記入ください。</p>
  <form action="" method="post" enctype="multipart/form-data">
      <dl>
          <dt>ニックネーム<span class="required">必須</span></dt>
          <dd>
            <?php if (isset($_POST["name"])){
                    echo sprintf('<input type="text" name="name" size="35" maxlength="255" value="%s" >' ,
                    h($_POST["name"]));
                } else {
                    echo '<input type="text" name="name" size="35" maxlength="255">' ;
                }
            ?>
            <?php if (isset($error['name'])): ?>
                <?php if ($error['name'] == 'blank') : ?>
                <p class="error">* ニックネームを入力してください</p>
                <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>メールアドレス<span class="required">必須</span></dt>
          <dd>
            <?php if (isset($_POST["mail"])){
                    echo sprintf('<input type="text" name="mail" size="35" maxlength="255" value="%s" >' ,
                    h($_POST["mail"]));
                } else {
                    echo '<input type="text" name="mail" size="35" maxlength="255">' ;
                }
            ?>
            <?php if (isset($error['mail'])): ?>
              <?php if ($error['mail'] == 'blank') : ?>
              <p class="error">* メールアドレスを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['mail'] == 'duplicate'): ?>
                <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
              <?php endif ?>
            <?php endif ; ?>
          </dd>
          <dt>パスワード<span class="required">必須</span></dt>
          <dd>
            <input type="password" name="password" size="10" maxlength="20">
            <?php if (isset($error['password'])): ?>
              <?php if ($error['password'] == 'blank') : ?>
              <p class="error">* パスワードを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['password'] == 'length') : ?>
              <p class="error">* パスワードは4文字以上で入力してください</p>
              <?php endif ; ?>
              <?php if ($error['password'] == 'notsame') : ?>
              <p class="error">* 入力されたパスワードが一致していません</p>
              <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>パスワード(再入力)<span class="required">必須</span></dt>
          <dd>
            <input type="password" name="password2" size="10" maxlength="20">
          </dd>
        </dl>
        <div><input type="submit" value="入力内容を確認する"></div>
  </form>
</body>
</html>
