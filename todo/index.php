<?php
  session_start();
  require('dbconnect.php');
  require('functionh.php');

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    # ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM users WHERE id=%d',
      mysqli_real_escape_string($db,$_SESSION['id'])
      );
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);
  } else {
    // ログインしてない
    header('Location:login.php');
    exit();
  }

  // タスクを記録する
  if (isset($_POST['task_title'])) {
    $sql = sprintf('INSERT INTO tasks SET user_id=%d, title="%s", created=NOW()',
      mysqli_real_escape_string($db, $_SESSION['id']),
      mysqli_real_escape_string($db, $_POST['task_title'])
      );
    mysqli_query($db, $sql) or die(mysqli_error($db));
  }

  //未完了タスクを取得する
  $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND finish_flg=0 ORDER BY created DESC',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $tasks = mysqli_query($db, $sql) or die(mysqli_error($db));

  // 完了タスクを取得する
  $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND finish_flg=1 ORDER BY modified DESC',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $finishedTasks = mysqli_query($db, $sql) or die(mysqli_error($db));

  // カテゴリを記録する
  if (isset($_POST['category_name'])) {
    $sql = sprintf('INSERT INTO categories SET user_id=%d, name="%s", created=NOW()',
      mysqli_real_escape_string($db, $_SESSION['id']),
      mysqli_real_escape_string($db, $_POST['category_name'])
      );
    mysqli_query($db, $sql) or die(mysqli_error($db));
  }

  // カテゴリを取得する
  $sql = sprintf('SELECT * FROM categories WHERE user_id=%d',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $categories = mysqli_query($db, $sql) or die(mysqli_error($db));

  // 詳細内のURLにリンクを設定する
  function makeLink($value){
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>', $value);
  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
  <title>ToDoリスト</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-sm-3">
        <div class="col-sm-2">
          <p>≡</p>
        </div>
        <div class="col-sm-10">
          <p>検索窓(予定地)</p>
        </div>
      </div>
        <div class="col-sm-9">
          <div class="col-sm-10">
            <p><?php if (isset($_REQUEST['category'])): ?>
              <?php echo $_REQUEST['category'] ?>
            <?php else: ?>
              タスク一覧
            <?php endif ?></p>
          </div>
          <div class="col-sm-2">
            <p>設定</p>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-3">
        こんにちは、<?php echo $member['name']; ?>さん
      </div>
      <div class="col-xs-9">
        <!-- ToDoを追加する -->
        <form action="" method="POST" accept-charset="utf-8">
          <input type="text" name="task_title" placeholder="新しいToDoを入力"><br>
          <input type="submit" value="ToDoを追加する">
        </form>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-3">
        <!-- カテゴリ一覧 -->
        <a href="index.php">タスク一覧</a><br>
        <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
        <a href="index.php?category=<?php echo $category['name']; ?>"><?php  echo $category['name']; ?></a><br>
        <?php } ?>
        <!-- 新しいカテゴリを作成する -->
        <form action="" method="POST" accept-charset="utf-8">
          <input type="text" name="category_name" placeholder="新しいカテゴリ名"><br>
          <input type="submit" value="新しいカテゴリを作成する">
        </form>
      </div>
      <div class="col-xs-9">
        <!-- タスク一覧を表示 -->
        <?php while ($task = mysqli_fetch_assoc($tasks)) { ?>
        <form action="finish.php" method="post" accept-charset="utf-8">
          <input type="checkbox" name="<?php echo $task['id'] ?>" value="finish">
          <span><?php  echo $task['title']; ?></span><br>
          <?php } ?>
          <?php while ($finishedTask = mysqli_fetch_assoc($finishedTasks)) { ?>
          <form action="finish.php" method="post" accept-charset="utf-8">
            <input type="checkbox" name="<?php echo $finishedTask['id'] ?>" value="finish" checked="checked">
            <span style="color:#A9A9A9"><?php  echo $finishedTask['title']; ?></span><br>
            <?php } ?>
        <input type="submit" value="チェックしたタスクを完了にする">
        </form>
      </div>
    </div>
  </div>
  <div  class="container">
    <div class="row">
      フッターパート
    </div>
  </div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>

</body>
</html>
