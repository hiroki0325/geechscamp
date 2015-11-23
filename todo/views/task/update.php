<?php
  // ログインの確認
  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }

  // 現在のタスク情報の取得
  $sql = sprintf('SELECT * FROM tasks WHERE id=%d',
    mysqli_real_escape_string($db, $_REQUEST['task_id'])
    );
  $tasks = mysqli_query($db, $sql) or die(mysqli_error($db));
  $task = mysqli_fetch_assoc($tasks);

  // カテゴリ一覧を取得する
  $sql = sprintf('SELECT * FROM categories WHERE user_id=%d',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $categories = mysqli_query($db, $sql) or die(mysqli_error($db));

  // 情報が送信された後なら、このあとの処理を実行する
  if (isset($_POST['modified_title'])) {

    // 送信内容の検査
      if ($_POST['modified_title'] == '') {
        $error['modified_title'] = 'empty';
      }
      if ($_POST['deadline'] =='') {
        $_POST['deadline'] ="NULL";
      }else{
        $_POST['deadline'] = mysqli_real_escape_string($db, $_POST['deadline']);
        $_POST['deadline'] ='"'.$_POST['deadline'].'"';
      }

    // タスク内容のアップデート処理
    if (empty($error)) {

      // チェックがあれば完了にする、なければ未完了にする
      //// ToDo 期限に””を付けるためにmysqli_real_escape_stringを外してしまったがいかがなものか。
      if (isset($_POST['finish_flg'])) {
        $sql = sprintf('UPDATE tasks SET title="%s", category_id=%d, detail="%s", deadline=%s, finish_flg=1, modified=NOW() WHERE id=%d AND user_id=%d',
          mysqli_real_escape_string($db, $_POST['modified_title']),
          mysqli_real_escape_string($db, $_POST['category_id']),
          mysqli_real_escape_string($db, $_POST['detail']),
          $_POST['deadline'],
          mysqli_real_escape_string($db, $_REQUEST['task_id']),
          mysqli_real_escape_string($db, $_SESSION['id'])
          );
      } else {
        $sql = sprintf('UPDATE tasks SET title="%s", category_id=%d, detail="%s", deadline=%s, finish_flg=0, modified=NOW() WHERE id=%d AND user_id=%d',
          mysqli_real_escape_string($db, $_POST['modified_title']),
          mysqli_real_escape_string($db, $_POST['category_id']),
          mysqli_real_escape_string($db, $_POST['detail']),
          $_POST['deadline'],
          mysqli_real_escape_string($db, $_REQUEST['task_id']),
          mysqli_real_escape_string($db, $_SESSION['id'])
          );
      }

      mysqli_query($db, $sql) or die(mysqli_error($db));

      if (isset($_POST['category_id'])) {
        $param = $_POST['category_id'];
        header("Location: ../index.php?category={$param}");
        exit();
      } else {
        header('Location: ../index.php');
        exit();
      }
    }

  }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>タスクを編集</title>
  <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
  <form action="" method="post" accept-charset="utf-8">
    <label for="modified_title" class="require">タイトル</label><br>
    <?php if (isset($error['modified_title']) && $error == 'empty'): ?>
      <p class="error">* タイトルを入力してください</p>
    <?php endif; ?>
    <input type="text" name="modified_title" value=<?php echo $task['title']; ?> required><br>
    <label for="" class="">カテゴリ</label><br>
    <select name="category_id">
      <option value="">カテゴリを選択してください</option>
      <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
        <option value="<?php echo $category['id'] ?>" <?php if($category['id'] == $task['category_id']){echo "selected";} ?> >
          <?php echo $category['name'] ?>
        </option>
      <?php } ?>
    </select><br>
    <label for="detail">詳細</label><br>
    <input type="text" name="detail" value=<?php echo $task['detail']; ?> ><br>
    <label for="deadline">期限</label><br>
    <input type="date" name="deadline" value=<?php echo $task['deadline']; ?> ><br>
    <label for="">完了</label><br>
    <input type="checkbox" name="finish_flg" value="1"
    <?php if ($task['finish_flg'] == 1)
    { echo 'checked="checked"';  } ?>
    ><br>
    <input type="submit" value="変更を確定する">
  </form>
</body>
</html>
