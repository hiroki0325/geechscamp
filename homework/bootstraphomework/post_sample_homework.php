<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <!-- bootstrapの命令文のひとつで、スマホ対応させる際に必須の記述 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ポストサンプル</title>
    <!-- Bootstrap core CSS -->
    <!-- 相対パスで指定する -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- JavaScriptファイルを読み込むためのリンクタグ -->
    <!-- 直接WEB上にあるファイルをURLで指定して読み込む -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- ファイルのパスを指定して読み込む -->
    <script src="assets/js/chart.js"></script>

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-xs-8 col-xs-offset-2 centered">
        <h1>ポストサンプル</h1>
      </div>
    </div>
  </div>

  <form action="answer.php" method="post">

    <div class="container">
      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          ニックネーム：
        <input type="text" name="nickname">
        </div>
      </div>

      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
        ひとこと：
        <textarea rows="4" cols="40" name="comment" placeholder="つぶやく"></textarea>
        </div>
      </div>

      <div class="row">
        <div class="col-xs-8 col-xs-offset-2 centered">
          <input type="submit">
        </div>
      </div>
    </div>
  </form>
  <!-- Bootstrap core JavaScript
 ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
   <script src="assets/js/bootstrap.js"></script>

</body>
</html>
