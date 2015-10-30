<?php
  session_start();
  require('../dbconnect.php');

  if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    // カテゴリーを検査する
    $sql = sprintf('SELECT * FROM categories WHERE id=%d',
      mysqli_real_escape_string($db, $id)
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    if ($table['user_id'] == $_SESSION['id']) {
      // カテゴリーの削除
      $sql = sprintf('DELETE FROM categories WHERE id=%d',
        mysqli_real_escape_string($db, $id)
      );
      mysqli_query($db, $sql) or die(mysqli_error($db));
    }

    // 削除したカテゴリーが設定されていたToDoのカテゴリ情報をクリア
    $sql = sprintf('UPDATE tasks SET category_id=0 WHERE category_id=%d',
      mysqli_real_escape_string($db, $id)
      );
    mysqli_query($db, $sql) or die(mysqli_error($db));
  }

  header('Location: ../index.php');
  exit();
?>
