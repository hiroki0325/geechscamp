<?php
    // DB内のblogsテーブルとのデータのやりとりを担当するファイル
    // echo "blog model file";

    // データを取得する(model)
    $sql = 'SELECT * FROM ' . $plural_resorce;
    $resorces = mysqli_query($db, $sql) or die(mysqli_error($db));
?>
