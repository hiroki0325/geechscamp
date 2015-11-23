<?php
  if (isset($_SESSION['id'])) {
    $id = $_REQUEST['task_id'];

    // タスクを検査する
    $sql = sprintf('SELECT * FROM tasks WHERE id=%d',
      mysqli_real_escape_string($db, $id)
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    if ($table['user_id'] == $_SESSION['id']) {
      // カテゴリーの削除
      $sql = sprintf('DELETE FROM tasks WHERE id=%d',
        mysqli_real_escape_string($db, $id)
      );
      mysqli_query($db, $sql) or die(mysqli_error($db));
    }
  }

  header('Location: ../index.php');
  exit();
?>
