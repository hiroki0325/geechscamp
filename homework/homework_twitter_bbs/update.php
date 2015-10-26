<?php
  session_start();
  require('dbconnect.php');

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    # ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM members WHERE id=%d',
      mysqli_real_escape_string($db,$_SESSION['id'])
      );
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);
  } else {
    // ログインしてない
    header('Location:login.php');
    exit();
  }

  if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    // 投稿を検査する
    $sql = sprintf('SELECT * FROM posts WHERE id=%d',
      mysqli_real_escape_string($db, $id)
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    if ($table['member_id'] == $_SESSION['id']) {
      // 編集
      if (!empty($_POST)) {
        if ($_POST['message'] != '') {
          $sql = sprintf('UPDATE posts SET message="%s", modified=NOW() WHERE id=%d',
            mysqli_real_escape_string($db,$_POST['message']),
            mysqli_real_escape_string($db, $id)
            );
          mysqli_query($db,$sql) or die(mysqli_error($db));

          header('Location:index.php');
          exit();
        }
      }
    }
  }else{
    header('Location: index.php');
    exit();
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>編集画面</title>
</head>
<body>
  <form action="" method="post">
    <dl>
    <dt><?php echo htmlspecialchars($member['name']); ?>さん、編集したいメッセージをどうぞ</dt>
      <dd>
        <textarea name="message" cols="50" rows="5"><?php if(isset($table)){
            echo htmlspecialchars($table['message'], ENT_QUOTES, 'UTF-8');
          }?></textarea>
      </dd>
    </dl>
    <div>
      <input type="submit" value="投稿する">
    </div>
  </form>
</body>
</html>
