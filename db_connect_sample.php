<?php
    // DBへの接続コードテンプレート
    $db = mysqli_connect('localhost','root','mysql','test_db');
    //                               ホスト名,ユーザー,パスワード,データベース名
    mysqli_set_charset($db, 'utf-8');

    // PHP5.5系 関数
    //// 5.5系から推奨になった関数がmysqli関数です。
    //// 5.3系まではmysql関数を使用していましたが、現在は非推奨となっているため、注意しましょう。
?>


<?php
    // 情報を取得する
    //// SQL 文を作る
    $sql = 'SELECT * FROM posts';

    //// DBから情報を取得する
    $posts = mysqli_query($db,$sql);

    // query(クエリ)について
    //// データへの処理自体のこと
?>

<?php
    // 取得した情報を表示する
    //// 使えるデータに変換します(mysqli_fetch_assoc関数を使用する)
    //// $postsはqueryを叩いた時点では表示できるフォーマットではないです。
    //// 繰り返し構文を使い、$postsの中にあるデータを1つずつ、使えるフォーマットに変換して取り出し、表示します。

    while ( $post = mysqli_fetch_assoc($posts)) {
      // 繰り返し処理でデータを表示
      // var_dump($post);
      echo $post["id"]."：".$post["nickname"]."[".$post["comment"]."]"."-".$post["created"];
      echo "<br>";
    }

?>
