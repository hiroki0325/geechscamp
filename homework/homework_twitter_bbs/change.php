<?php
    session_start();
    require('dbconnect.php');

    if (!empty($_POST)) {
      // エラー項目の確認
      if ($_POST['name'] =='') {
        $error['name'] = 'blank' ;
      }
      if ($_POST['email']=='') {
        $error['email'] = 'blank' ;
      }
      if (strlen($_POST['password']) < 4 ) {
        $error['password'] = 'length' ;
      }
      if ($_POST['password'] =='') {
        $error['password'] = 'blank' ;
      }
      $fileName = $_FILES['image']['name'] ;
      if (!empty($fileName)) {
        $ext = substr($fileName, -3) ;
        if ($ext != 'jpg' && $ext != 'gif') {
          $error['image'] = 'type' ;
        }
      }

      // 重複アカウントのチェック
      if (!empty($_POST)) {
          if (empty($error)) {
            $sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
              mysqli_real_escape_string($db, $_POST["email"])
              );
            $record = mysqli_query($db, $sql) or die(mysqli_error($db));
            $table = mysqli_fetch_assoc($record);
            if ($table['cnt'] > 0 ){
              $error['email'] = 'duplicate';
            }
          }
      }

      if (empty($error)) {
        // 画像をアップロードする
        $image = date('YmdHis').$_FILES['image']['name'] ;
        move_uploaded_file($_FILES['image']['tmp_name'],'member_picture/'.$image) ;
        $_SESSION['join'] = $_POST ;
        $_SESSION['join']['image']= $image ;
        header('Location: check.php');
        exit();
      }
    }

    // 書き直し
    if (!empty($_SESSION['join'])) {
        if (!empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'rewrite') {
              $_POST = $_SESSION['join'];
              $ext = substr($_SESSION['join']['image'], -3);
              if ($ext == 'jpg' || $ext == 'gif') {
                  $fileName = 'rewrite';
              }
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
  <p>次のフォームに変更後の情報をご記入ください。</p>
  <form action="" method="post" enctype="multipart/form-data">
      <dl>
          <dt>ニックネーム<span class="required">必須</span></dt>
          <dd>
            <?php if (isset($_POST["name"])){
                    echo sprintf('<input type="text" name="name" size="35" maxlength="255" value="%s" >' ,
                    htmlspecialchars($_POST["name"], ENT_QUOTES, "UTF-8" ));
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
            <?php if (isset($_POST["email"])){
                    echo sprintf('<input type="text" name="email" size="35" maxlength="255" value="%s" >' ,
                    htmlspecialchars($_POST["email"], ENT_QUOTES, "UTF-8" ));
                } else {
                    echo '<input type="text" name="email" size="35" maxlength="255">' ;
                }
            ?>
            <?php if (isset($error['email'])): ?>
              <?php if ($error['email'] == 'blank') : ?>
              <p class="error">* メールアドレスを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['email'] == 'duplicate'): ?>
                <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
              <?php endif ?>
            <?php endif ; ?>
          </dd>
          <dt>パスワード<span class="required">必須</span></dt>
          <dd>
            <?php if (isset($_POST["password"])){
                    echo sprintf('<input type="password" name="password" size="10" maxlength="20" value="%s" >' ,
                    htmlspecialchars($_POST["password"], ENT_QUOTES, "UTF-8" ));
                } else {
                    echo '<input type="password" name="password" size="10" maxlength="20">' ;
                }
            ?>
            <?php if (isset($error['password'])): ?>
              <?php if ($error['password'] == 'blank') : ?>
              <p class="error">* パスワードを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['password'] == 'length') : ?>
              <p class="error">* パスワードは4文字以上で入力してください</p>
              <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>写真など</dt>
          <dd>
            <input type="file" name="image" size="35">
            <?php if (isset($error['image'])): ?>
              <?php if ($error['image'] == 'type'): ?>
              <p class="error">* 写真などは「.gif」または「.jpg」の画像を指定してください</p>
              <?php endif ; ?>
            <?php endif ; ?>
            <?php if ( isset($fileName) && $fileName !='' ): ?>
              <?php if (empty($error['image'])): ?>
                  <p class="error">* 恐れ入りますが、画像を改めて指定してください</p>
              <?php endif ; ?>
            <?php endif ; ?>

          </dd>
        </dl>
        <div><a href="index.php">投稿画面に戻る</a>｜<input type="submit" value="入力内容を確認する"></div>
  </form>
</body>
</html>
