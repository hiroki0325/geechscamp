<?php
  session_start();
  require('../dbconnect.php');
  require('../functionh.php');

  // ログインの確認
  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];

 // カテゴリを記録する
  if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
    $sql = sprintf('INSERT INTO categories SET user_id=%d, name="%s", created=NOW()',
      mysqli_real_escape_string($db, $_SESSION['id']),
      mysqli_real_escape_string($db, $_POST['category_name'])
      );
    mysqli_query($db, $sql) or die(mysqli_error($db));
  }
}

  header('Location: ../index.php');
  exit();

?>
