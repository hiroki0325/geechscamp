<?php
  session_start();
  require('../dbconnect.php');
  require('../functionh.php');

  // ログインの確認
  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
  }

  // カテゴリ名の編集
  $sql = sprintf('UPDATE categories SET name="%s" WHERE id=%d',
    mysqli_real_escape_string($db, $_POST['edited_categoryname']),
    mysqli_real_escape_string($db, $_POST['category_id'])
    );
  mysqli_query($db, $sql) or die(mysqli_error($db));

  if (isset($_POST['category_id'])) {
    $param = $_POST['category_id'];
    header("Location: ../index.php?category={$param}");
    exit();
  } else {
    header('Location: ../index.php');
    exit();
  }

?>
