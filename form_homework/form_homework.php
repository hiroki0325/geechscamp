<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP フォーム 宿題</title>
</head>
<body>
  <h1>個人情報を入力せよ</h1>
  <form action="regist_homework.php" method="post" accept-charset"utf-8">
    名前：<br>
    <input type="text" name="name" size="30" value=" "><br>
    性別：<br>
    <select name="sex" >
      <option value="1">男</option>
      <option value="2">女</option>
    </select><br>
    年齢：<br>
      <select name="age">
        <?php for ($i=1; $i <= 100; $i++) {
           echo " <option value=".$i.">".$i."</option>";
        }
        ?>
      </select><br>
    メールアドレス：<br>
    <input type="text" name="mail" size="30" value=" "><br>
    パスワード；<br>
    <input type="password" name="password" value="" size="30"><br>
    一言コメント：<br>
    <input type="textarea" name="comment" cols="30" rows="5"><br>
    <input type="submit" name="send" value="同意して送信" style="width:100px">
  </form>
  <h2>搾取した個人情報は悪意を持って扱います</h2>
</body>
</html>
