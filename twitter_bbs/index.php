<?php
  session_start();
  require('dbconnect.php');

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 >time() ) {
    // ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM members WHERE id=%d',
      mysqli_real_escape_string($db, $_SESSION['id'])
    );

    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);
  } else {
    // ログインしていない
    header('Location: login.php');
    exit();
  }

  // 投稿を記録する
  if (!empty($_POST)) {
    if ($_POST['message'] != '') {
      $sql = sprintf('INSERT INTO posts SET member_id=%d, message="%s", created=NOW()',
        mysqli_real_escape_string($db, $member['id']),
        mysqli_real_escape_string($db, $_POST['message'])
        );

      mysqli_query($db, $sql) or die(mysqli_error($db));

      header('Location: index.php');
      exit();
    }
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>投稿画面</title>
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <form action="" method="post">
    <div>
      <label for=""><?php echo htmlspecialchars($member['nickname']); ?>さん、メッセージをどうぞ</label><br>
      <textarea name="message" cols="50" rows="5"></textarea>
    </div>

    <div>
      <input type="submit" value="つぶやく">
    </div>
  </form>
</body>
</html>
