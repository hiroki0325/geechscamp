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

  // 投稿を記録する
  if (!empty($_POST)) {
    if ($_POST['message'] != '') {
      $sql = sprintf('INSERT INTO posts SET member_id=%d, message="%s", reply_post_id=%d, created=NOW()',
        mysqli_real_escape_string($db, $member['id']),
        mysqli_real_escape_string($db,$_POST['message']),
        mysqli_real_escape_string($db,$_POST['reply_post_id'])
        );
      mysqli_query($db,$sql) or die(mysqli_error($db));

      header('Location:index.php');
      exit();
    }
  }

  //投稿を取得する
  // Todo ↓この書き方はなんだ？
  $sql = sprintf('SELECT m.name, m.picture, p.* FROM members m,posts p WHERE m.id=p.member_id ORDER BY p.created DESC');
  $posts = mysqli_query($db, $sql) or die(mysqli_error($db));

  // 返信の場合
  if (isset($_REQUEST['res'])) {
    $sql = sprintf('SELECT m.name, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=%d ORDER BY p.created DESC',
      mysqli_real_escape_string($db, $_REQUEST['res'])
      );
    $record = mysqli_query($db, $sql)  or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    $message = '@'.$table['name'].' '.$table['message'];
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
  <title>ひとこと掲示板</title>
</head>
<body>
  <div id="wrap">
    <div id="head">
      <h1>ひとこと掲示板</h1>
    </div>
    <div id="content">
      <form action="" method="post">
        <dl>
        <dt><?php echo htmlspecialchars($member['name']); ?>さん、メッセージをどうぞ</dt>
          <dd>
            <!-- Todo↓ここの改行／インデントの仕方が気になる -->
            <textarea name="message" cols="50" rows="5"><?php if(isset($message)){
                echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
              }?></textarea>
            <?php if (isset($_REQUEST['res'])): ?>
              <input type="hidden" name="reply_post_id" value="<?php echo htmlspecialchars($_REQUEST['res'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php else: ?>
              <input type="hidden" name="reply_post_id">
            <?php endif ?>
          </dd>
        </dl>
        <div>
          <input type="submit" value="投稿する">
        </div>
      </form>

<?php while ($post = mysqli_fetch_assoc($posts)): ?>
      <div class="msg">
        <img src="member_picture/<?php echo htmlspecialchars($post['picture'], ENT_QUOTES, 'UTF-8'); ?>" width="48" height="48" alt="<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>">
        <p>
          <?php echo htmlspecialchars($post['message'], ENT_QUOTES, 'UTF-8'); ?>
          <span class="name">
            (<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>)
          </span>
          [<a href="index.php?res=<?php echo htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8') ?>">Re</a>]
        </p>
        <p class="day"><?php echo htmlspecialchars($post['created'], ENT_QUOTES, 'UTF-8'); ?></p>
      </div>
    <?php endwhile; ?>
    </div>
<!--     <div id="foot">
      <p><img src="images/txt_copyright.png" width="136" height="15" alt="(c) H20 SPACE, Mynavi"></p>
    </div> -->
  </div>
</body>
</html>
