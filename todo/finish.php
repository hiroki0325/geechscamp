<?php
  session_start();
  require('dbconnect.php');
  require('functionh.php');

  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    // タスクを一旦全部取り出す
    $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d',
      mysqli_real_escape_string($db, $id)
      );
    $record = mysqli_query($db, $sql);

    while ($table = mysqli_fetch_assoc($record)) {
      // チェックされたもののみに処理を行う
      $i = $table['id'];
      if (isset($_POST["$i"])) {
        $sql = sprintf('UPDATE tasks SET finish_flg=1 WHERE id=%d',
          mysqli_real_escape_string($db, $table['id'])
          );
        mysqli_query($db, $sql)  or die(mysqli_error($db));
      }else{
        $sql = sprintf('UPDATE tasks SET finish_flg=0 WHERE id=%d',
          mysqli_real_escape_string($db, $table['id'])
          );
        mysqli_query($db, $sql)  or die(mysqli_error($db));
      }
    }
  }

  header('Location: index.php');
  exit();
?>
