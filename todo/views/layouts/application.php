<!DOCTYPE html>
<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
  <title>シンプルTodoアプリ</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../views/assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../views/assets/css/main.css">
  <link rel="stylesheet" href="../views/assets/css/sideMenu.css">
  <link rel="stylesheet" href="../views/assets/jquery/jquery-ui.min.css">

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

  <!-- JavaScript -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

</head>
<body>
  <?php
      include('./views/' . $resource . '/' . $action . '.php');
   ?>

   <!-- フッター用コンテナ -->
   <div  class="container">
     <div class="row">
       フッターパート
     </div>
   </div>

   <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="../views/assets/js/bootstrap.js"></script>
</body>
</html>
