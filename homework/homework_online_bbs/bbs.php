<?php
    //DBへの接続
    $db = mysqli_connect('localhost','root','mysql','online_bbs');
    mysqli_set_charset($db,'utf8');
?>

<?php
    // var_dump($_POST);

    //DBに保存
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //リクエストメソッドがPOSTだった場合のみ処理

      // mysqli_real_escape_string()について
      // inputタグに悪意あるユーザーがSQL文などを入力した際に、
      // ただの文字列として受け取るように文字をエスケープする関数
      $nickname = mysqli_real_escape_string($db, $_POST['nickname']);
      $comment  = mysqli_real_escape_string($db, $_POST['comment']);
      $sql = sprintf('INSERT INTO posts SET nickname="%s", comment="%s", created=NOW()',
          $nickname,
          $comment
      );

      mysqli_query($db,$sql);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示板</title>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/css/form.css">

</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h1>ひとこと掲示板</h1>
        <form action="bbs.php" method="post">
          <div class="form-group">
          <label for="validate-text">ニックネーム</label>
            <div class="input-group">
              <input type="text" class="form-control" name="nickname" id="validate-text" placeholder="ニックネーム" required>
              <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
            </div>
          </div>

          <div class="form-group">
              <label for="validate-text">ひとこと</label>
              <div class="input-group">
                <input type="text" class="form-control" name="comment" id="validate-text" placeholder="ひとこと" required>
                <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
              </div>
          </div>

          <div>
           <button type="submit" class="btn btn-primary col-xs-12" disabled>つぶやく</button>
          </div>
        </form>

      </div>

      <div class="col-md-8">
        <?php
            // データの取得と表示
            $sql = 'SELECT * FROM posts ORDER BY `created` DESC';
            $posts = mysqli_query($db,$sql) or die(mysqli_error($db));
        ?>

        <ul>
          <?php while ($post = mysqli_fetch_assoc($posts)): ?>
          <li><?php echo $post['nickname'] ?>:<?php echo $post['comment'] ?></li>
        <?php endwhile; ?>
        </ul>
      </div>
    </div>
  </div>

<!-- スニペットベタ張り -->
<!--
<div class="container">
  <div class="row">
    <h2>Input Validation + Colorful Input Groups</h2>
  </div>

    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
            <form method="post">
        <div class="form-group">
              <label for="validate-text">Validate Text</label>
          <div class="input-group">
            <input type="text" class="form-control" name="validate-text" id="validate-text" placeholder="Validate Text" required>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
        <div class="form-group">
              <label for="validate-optional">Optional</label>
          <div class="input-group">
            <input type="text" class="form-control" name="validate-optional" id="validate-optional" placeholder="Optional">
            <span class="input-group-addon info"><span class="glyphicon glyphicon-asterisk"></span></span>
          </div>
        </div>
          <div class="form-group">
              <label for="validate-optional">Already Validated!</label>
            <div class="input-group">
            <input type="text" class="form-control" name="validate-text" id="validate-text" placeholder="Validate Text" value="Validated!" required>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
        <div class="form-group">
              <label for="validate-email">Validate Email</label>
          <div class="input-group" data-validate="email">
            <input type="text" class="form-control" name="validate-email" id="validate-email" placeholder="Validate Email" required>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
          <div class="form-group">
              <label for="validate-phone">Validate Phone</label>
          <div class="input-group" data-validate="phone">
            <input type="text" class="form-control" name="validate-phone" id="validate-phone" placeholder="(814) 555-1234" required>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
            <div class="form-group">
              <label for="validate-length">Minimum Length</label>
          <div class="input-group" data-validate="length" data-length="5">
            <textarea type="text" class="form-control" name="validate-length" id="validate-length" placeholder="Validate Length" required></textarea>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
                <div class="form-group">
                <label for="validate-select">Validate Select</label>
          <div class="input-group">
                        <select class="form-control" name="validate-select" id="validate-select" placeholder="Validate Select" required>
                            <option value="">Select an item</option>
                            <option value="item_1">Item 1</option>
                            <option value="item_2">Item 2</option>
                            <option value="item_3">Item 3</option>
                        </select>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
              <div class="form-group">
              <label for="validate-number">Validate Number</label>
          <div class="input-group" data-validate="number">
            <input type="text" class="form-control" name="validate-number" id="validate-number" placeholder="Validate Number" required>
            <span class="input-group-addon danger"><span class="glyphicon glyphicon-remove"></span></span>
          </div>
        </div>
                <button type="submit" class="btn btn-primary col-xs-12" disabled>Submit</button>
            </form>
        </div>
    </div>
</div>
 -->

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/form.js"></script>

</body>
</html>
