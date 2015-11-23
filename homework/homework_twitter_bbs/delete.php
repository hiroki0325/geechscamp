<?php
  session_start();
  require('dbconnect.php');

  if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];

    // 投稿を検査する
    $sql = sprintf('SELECT * FROM posts WHERE id=%d',
      mysqli_real_escape_string($db, $id)
      );
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $table = mysqli_fetch_assoc($record);
    if ($table['member_id'] == $_SESSION['id']) {
      // 削除
      $sql = sprintf('DELETE FROM posts WHERE id=%d',
        mysqli_real_escape_string($db, $id)
      );
      mysqli_query($db, $sql) or die(mysqli_error($db));
    }
  }

  header('Location: index.php');
  exit();
?>
