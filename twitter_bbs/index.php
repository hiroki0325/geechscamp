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
      $sql = sprintf('INSERT INTO posts SET member_id=%d, message="%s", reply_post_id=%d, created=NOW()',
        mysqli_real_escape_string($db, $member['id']),
        mysqli_real_escape_string($db, $_POST['message']),
        mysqli_real_escape_string($db, $_POST['reply_post_id'])
        );

      mysqli_query($db, $sql) or die(mysqli_error($db));

      header('Location: index.php');
      exit();
    }
  }

  // 投稿を取得する
  //// URLに?page=2などのページ番号があれば、それを取得して$pageに代入
  $page = $_REQUEST['page'];
  if ($page == '') {
    ////// URLに?pageがなければ1ページ目とみなし$pageに1を代入します
    $page = 1;
  }

  //// max関数
  //// ()内に指定した複数データから一番大きい値を取得する
  //// もし、ユーザーがURLに?page=0.8のような値を入れてリクエストした場合に、
  //// 強制的に1ページ目に飛ぶようにしている
  $page = max($page, 1);

  // 最終ページを取得する
  //// SELECT COUNTを使ってpostsテーブルのデータの件数を取得
  $sql = 'SELECT COUNT(*) AS cnt FROM posts';

  $recordSet = mysqli_query($db, $sql) or die(mysqli_error($db));
  $table = mysqli_fetch_assoc($recordSet);

  //// ceil関数
  //// 小数点以下切り上で数字を作る 例：1.8が指定された場合は切り上げて2を返す
  $maxPage = ceil($table['cnt'] / 5); // ←5件がマックスで表示したいデータ件数のため5で割る

  // もし、ユーザーがURLに?page=100などのような大きすぎる値を入れてリクエストを送ってきた場合に、
  // DBに保存されているデータの件数を5で割り最大ページ数を算出し、
  // もしそれ以上の値がセットされていた場合はmin関数を使用して最大ページ数で表示する

  //// min関数
  //// ()内に指定した複数データから一番小さい値を取得する
  $page = min($page, $maxPage);

  // 1ページ目なら$startなら0が代入され、DBからSELECT ~ LIMIT 0,5 とすることで、
  // 1個目のデータ(idが1のもの)から5件取得するための$startを用意
  // もししていされたページが2ページ目なら、$pageには2が入り、計算処理の結果$startには5が入ります。
  // その後SELECT ~ LIMIT 5,5 というsql文が発行され、6個目のデータから5件取得する処理が作られます。
  $start = ($page-1) * 5;
  $start = max(0, $start);

  $sql = sprintf('SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id = p.member_id ORDER BY p.created DESC LIMIT %d, 5',
    $start
    );

  $posts = mysqli_query($db,$sql) or die(mysqli_error($db));
  // var_dump($posts);

  // $post = mysqli_fetch_assoc($posts);
  // var_dump($post);

  // 返信の場合
  if (isset($_REQUEST['res'])) {
    $sql = sprintf('SELECT m.nickname, m.picture, p.* FROM members m, posts p WHERE m.id=p.member_id AND p.id=%d ORDER BY p.created DESC',
        mysqli_real_escape_string($db, $_REQUEST['res'])
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    $message = '@'.$table['nickname'].' '.$table['message'];
  }

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
      <?php if (isset($_REQUEST['res'])): ?>
        <textarea name="message" cols="50" rows="5"><?php echo h($message); ?></textarea>
        <input type="hidden" name="reply_post_id" value="<?php echo h($_REQUEST['res'])?>">
      <?php else: ?>
        <textarea name="message" cols="50" rows="5"></textarea>
      <?php endif; ?>
    </div>

    <div>
      <input type="submit" value="つぶやく">
    </div>
  </form>

  <?php while ($post = mysqli_fetch_assoc($posts)): ?>
    <div class="msg">
      <img src="member_picture/<?php echo h($post['picture']); ?>" width="48" height="48">
      <p>
        <?php echo h($post['message']); ?><span class="name">(<?php echo h($post['nickname']); ?>)</span>
        [<a href="index.php?res=<?php echo h($post['id']); ?>">Re</a>]

      </p>
      <p class="day">
        <a href="view.php?id=<?php echo h($post['id']); ?>">
         <?php echo h($post['created']); ?>
        </a>
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
