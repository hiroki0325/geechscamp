<?php
  session_start();
  require('dbconnect.php');

  // htmlspecialcharsのショートカット
  function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

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

  // 投稿を取得する
  $sql = 'SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC';

  $posts = mysqli_query($db,$sql) or die(mysqli_error($db));
  // var_dump($posts);

  // $post = mysqli_fetch_assoc($posts);
  // var_dump($post);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>投稿画面</title>
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
  <h1>ひとこと掲示板</h1>

  <div>
    <a href="logout.php">ログアウト</a>
  </div>

  <form action="" method="post">
    <div>
      <label for=""><?php echo htmlspecialchars($member['nickname']); ?>さん、メッセージをどうぞ</label><br>
      <textarea name="message" cols="50" rows="5"></textarea>
    </div>

    <div>
      <input type="submit" value="つぶやく">
    </div>
  </form>

  <?php while ($post = mysqli_fetch_assoc($posts)): ?>
    <div class="msg">
      <img src="member_picture/<?php echo h($post['picture']); ?>" width="48" height="48">
      <p><?php echo h($post['message']); ?><span class="name">(<?php echo h($post['nickname']); ?>)</span></p>
      <p class="day">
        <?php echo h($post['created']); ?>
        <?php if ($_SESSION['id'] == $post['member_id']): ?>
          <!-- $_SESSION['id']がログイン中のユーザーのID -->
          <!-- $post['member_id']が表示される投稿データ一件に登録されている投稿者のID -->
          [<a href="delete.php?id=<?php echo h($post['id']); ?>" style="color: #F33;">削除</a>]
      <?php endif; ?>
      </p>
    </div>
  <?php endwhile; ?>
</body>
</html>
