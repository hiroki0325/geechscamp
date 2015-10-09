<?php
    // データの挿入
    // DBへ接続
    $db = mysqli_connect('localhost','root','mysql','test_db') or die(mysqli_connect_error());
    mysqli_set_charset($db,'utf8');

   //指定した値をINSERT文を使ってDBに保存
    ////
    $sql = 'INSERT INTO posts (nickname,comment,created) VALUE ("しんのすけ","こんなの売れないっすよ",NOW())';
    mysqli_query($db,$sql);
?>
