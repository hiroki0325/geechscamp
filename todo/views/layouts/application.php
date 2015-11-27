<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
  <title>シンプルTodoアプリ</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../views/assets/css/sidemenu.css">
  <link rel="stylesheet" href="../views/assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../views/assets/css/main.css">
  <link rel="stylesheet" href="../views/assets/jquery/jquery-ui.min.css">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script type="text/javascript" src="../views/assets/jquery/jquery.js"></script>
  <script type="text/javascript" src="../views/assets/jquery/jquery-ui.min.js"></script>

</head>
<body>

  <?php include('./views/' . $resource . '/' . $action . '.php'); ?>

  <!-- フッター用コンテナ -->
  <div  class="container">
    <div class="row">
      <!-- フッターメニュー -->
      <div class="line"></div>
      <ul style="text-align: center;">
        <li style="margin-right: 20px;"><a href="">hoge</a></li>
        <li style="margin-right: 20px;"><a href="">fuga</a></li>
        <li style="margin-right: 20px;"><a href="">moge</a></li>
        <li><a href="">pugya</a></li>
      </ul>
    </div>
  </div>

   <!-- bootstrapメインjsの読み込み -->
   <script src="../views/assets/js/bootstrap.js"></script>

</body>
</html>
