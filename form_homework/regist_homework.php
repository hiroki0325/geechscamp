<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8">
<title>受信ページ</title>
</head>
<body>
  <table border="1">
    <tr>
      <td>名前</td><td><?php echo $_POST["name"] ?></td>
    </tr>
    <tr>
      <td>性別</td><td><?php echo $_POST["sex"] ?></td>
   </tr>
    <tr>
     <td>年齢</td><td><?php echo $_POST["age"] ?></td>
    </tr>
     <tr>
     <td>メールアドレス</td><td><?php echo $_POST["mail"] ?></td>
    </tr>
    <tr>
      <td>パスワード</td><td><?php echo $_POST["password"] ?></td>
    </tr>
    <tr>
      <td>一言コメント</td><td><?php echo $_POST["comment"] ?></td>
    </tr>
  </table>
</body>
</html>
