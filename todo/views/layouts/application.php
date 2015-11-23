<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>シンプルTodoアプリ</title>
  <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
  <title>ToDoリスト</title>

  <!-- CSS -->
  <link rel="stylesheet" href="../views/assets/css/bootstrap.css">
  <link rel="stylesheet" href="../views/assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../views/assets/css/main.css">
  <link rel="stylesheet" href="../views/assets/css/sideMenu.css">
  <!-- JavaScript -->
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
</head>
<body>
  <?php
      include('./views/' . $resource . '/' . $action . '.php');
   ?>

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

   <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="../views/assets/js/bootstrap.js"></script>
</body>
</html>
