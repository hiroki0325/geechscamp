<?php
  // DBに接続
    $db = mysqli_connect('localhost','root','mysql','homework_db');
    // 日本語に対応
    mysqli_set_charset($db,'utf-8');
?>

<?php
    //時刻を定義
    date_default_timezone_set('Asia/Tokyo');
    // $time = date("Y-m-d H:i:s");
    //DBにデータを送信
    $sql = sprintf(' INSERT INTO posts SET name="%s", sex="%s", age="%s", mail="%s", password="%s", comment="%s"' ,
        mysqli_real_escape_string ($db , $_POST['name']),
        mysqli_real_escape_string ($db , $_POST['sex']),
        mysqli_real_escape_string ($db , $_POST['age']),
        mysqli_real_escape_string ($db , $_POST['mail']),
        mysqli_real_escape_string ($db , $_POST['password']),
        mysqli_real_escape_string ($db , $_POST['comment'])
    );
    mysqli_query($db, $sql);
?>

<?php
    //SQLでDBから情報をガツッと取得（まだ使える形ではない！）
    $sql = 'SELECT * FROM posts';
    $posts = mysqli_query($db,$sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>受信ページ</title>
</head>
<body>
   <table border="1">
     <?php
      // queryで取得した情報を使える形に変換しつつ表示
          echo "
              <tr>
                  <td>名前</td>
                  <td>性別</td>
                  <td>年齢</td>
                  <td>メールアドレス</td>
                  <td>パスワード</td>
                  <td>一言コメント</td>
                  <td>登録日時</td>
              </tr>";
          while ( $post = mysqli_fetch_assoc($posts) ) {
              echo "<tr>" ;
              echo "<td>".$post["name"]." </td>" ;
              echo "<td>".$post["sex"]." </td>" ;
              echo "<td>".$post["age"] ."</td>" ;
              echo "<td>".$post["mail"] ."</td>" ;
              echo "<td>（非表示）</td>" ;
              echo "<td>".$post["comment"]." </td>" ;
              echo "<td>".$post["created"]." </td>" ;
              echo "</tr>" ;
          }
     ?>
   </table>
   <a href="form_homework.php">登録画面へ</a>
 </body>
 </html>
