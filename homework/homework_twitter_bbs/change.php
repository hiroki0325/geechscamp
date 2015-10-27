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
      if (strlen($_POST['modified_password']) >0 && strlen($_POST['modified_password']) < 4 ) {
        $error['modified_password'] = 'length' ;
      }
      if ($_POST['current_password'] =='') {
        $error['current_password'] = 'blank' ;
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
            $sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s" AND NOT id=%d',
              mysqli_real_escape_string($db, $_POST["email"]),
              mysqli_real_escape_string($db, $_SESSION["id"])
              );
            $record = mysqli_query($db, $sql) or die(mysqli_error($db));
            $table = mysqli_fetch_assoc($record);
            if ($table['cnt'] > 0 ){
              $error['email'] = 'duplicate';
            }
          }
        }

      // ユーザー情報の取得(現在のPWチェック用）
      if (!empty($_POST)) {
        $sql = sprintf('SELECT * FROM members WHERE id=%d AND password="%s"',
          mysqli_real_escape_string($db, $_SESSION['id']),
          mysqli_real_escape_string($db, sha1($_POST['current_password']))
          );
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        $table = mysqli_fetch_assoc($record);
        if (empty($table)) {
          $error['current_password'] = 'wrong';
        }
      }

      if (empty($error)) {
        // 画像をアップロードする
        if ($_FILES['image']['name'] != '') {
          $image = date('YmdHis').$_FILES['image']['name'] ;
          move_uploaded_file($_FILES['image']['tmp_name'],'member_picture/'.$image) ;
          $_SESSION['join'] = $_POST ;
          $_SESSION['join']['image']= $image ;
        }else{
          $_SESSION['join'] = $_POST ;
          $_SESSION['join']['image']= '' ;
        }
        header('Location: check.php');
        exit();
      }
    }

    // 書き直し
    if (!empty($_SESSION['join'])) {
        if (!empty($_REQUEST['action'])) {
            if ($_REQUEST['action'] == 'rewrite') {
              $_POST = $_SESSION['join'];
              if (!empty($_SESSION['join']['image'])) {
                $ext = substr($_SESSION['join']['image'], -3);
                if ($ext == 'jpg' || $ext == 'gif') {
                    $fileName = 'rewrite';
                }
              }
            }
        }
    }

    // ユーザー情報の取得（入力欄内表示用）
    if (empty($_POST)) {
      $sql = sprintf('SELECT * FROM members WHERE id=%d',
        mysqli_real_escape_string($db, $_SESSION['id'])
        );
      $members = mysqli_query($db, $sql) or die(mysqli_error($db));
      $_POST = mysqli_fetch_assoc($members);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アカウント編集画面</title>
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
                <p class="error">* 指定されたメールアドレスはすでに他のアカウントで登録されています</p>
              <?php endif ?>
            <?php endif ; ?>
          </dd>
          <dt>現在のパスワード<span class="required">※必須</span></dt>
          <dd>
            <input type="password" name="current_password" size="10" maxlength="20">
            <?php if (isset($error['current_password'])): ?>
              <?php if ($error['current_password'] == 'blank') : ?>
              <p class="error">* パスワードを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['current_password'] == 'length') : ?>
              <p class="error">* パスワードは4文字以上で入力してください</p>
              <?php endif ; ?>
              <?php if ($error['current_password'] == 'wrong'): ?>
                <p class="error">* パスワードが誤っています。正しいパスワードを入力してください</p>
              <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>変更後のパスワード<span class="required">任意</span></dt>
          <dd>
           <input type="password" name="modified_password" size="10" maxlength="20">
            <?php if (isset($error['modified_password'])): ?>
              <?php if ($error['modified_password'] == 'blank') : ?>
              <p class="error">* パスワードを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['modified_password'] == 'length') : ?>
              <p class="error">* 変更後のパスワードは4文字以上で入力してください</p>
              <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>写真など<span class="required">任意</span></dt>
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
