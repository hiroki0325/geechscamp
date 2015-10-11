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
    <link href="assets/css/form_homework.css" rel="stylesheet">

    <!-- JavaScriptファイルを読み込むためのリンクタグ -->
    <!-- 直接WEB上にあるファイルをURLで指定して読み込む -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!-- ファイルのパスを指定して読み込む -->
    <script src="assets/js/chart.js"></script>
    <script src="assets/js/form_homework.js"></script>

</head>
<body>
  <div class="container">
    <div class="col-xs-8 col-xs-offset-2 centered">
      <form action="answer.php" method="post">
        <div class="form-area">

          <div class="row">
            <h1>ポストサンプル</h1><br>
          </div>
          <div class="row form-group">
            <input type="text" name="nickname" class="form-control" placeholder="ニックネーム">
          </div>
          <br>
          <div class="row form-group">
            <textarea maxlength="140" rows="7" name="comment" placeholder="つぶやく" class="form-control"></textarea>
          </div>
          <div class="row form-group">
          <br><input type="submit" class="btn btn-primary pull-right">
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap core JavaScript
 ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
   <script src="assets/js/bootstrap.js"></script>

</body>
</html>
