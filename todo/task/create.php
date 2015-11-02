<?php
  session_start();
  require('../dbconnect.php');
  require('../functionh.php');

  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

    // タスクを記録する
    if (isset($_POST['task_title']) && $_POST['task_title'] != '') {
      $sql = sprintf('INSERT INTO tasks SET user_id=%d, title="%s", category_id=%d, created=NOW()',
        mysqli_real_escape_string($db, $_SESSION['id']),
        mysqli_real_escape_string($db, $_POST['task_title']),
        mysqli_real_escape_string($db, $_POST['category_id'])
        );
      mysqli_query($db, $sql) or die(mysqli_error($db));
    }
  }

  header('Location: ../index.php');
  exit();

?>
