<?php
    session_start();
    require('dbconnect.php');

    // htmlspecialcharsのショートカット
    function h($value) {
      return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    // このページにアクセスした際にログインしていなければindex.phpにリダイレクト
    if (empty($_REQUEST['id'])) {
        header('Location: index.php');
        exit();
    }

    // 選択したページの情報をDBから取得するためのsql文作成と実行
    $sql = sprintf('SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=%d ORDER BY p.created DESC',
      mysqli_real_escape_string($db, $_REQUEST['id'])
      );
    $posts = mysqli_query($db, $sql) or die(mysqli_error($db));
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>詳細ページ</title>
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
</head>
<body>
  <h1>ひとこと掲示板</h1>
  <p>&laquo;<a href="index.php">一覧に戻る</a></p>

  <?php if ($post = mysqli_fetch_assoc($posts)): ?>
    <div class="msg">
      <img src="member_picture/<?php echo h($post['picture']); ?>" width='48' height="48">
      <p><?php echo h($post['message']); ?><span class="name"><?php echo h($post['nickname']); ?></span></p>
      <p class="day"><?php echo h($post['created']); ?></p>
    </div>
  <?php else: ?>
  <p>そのページは存在しないかURLが間違っています。</p>
  <?php endif; ?>

</body>
</html>
