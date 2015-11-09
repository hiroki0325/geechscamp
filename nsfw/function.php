<?php
    // 関数について
    // 言語や仕様によってはファンクション、メソッドなどとも呼ばれる
    // 何度も同じコードを書くような場合はひとつの関数にまとめ、
    // その関数を呼び出すだけでコードを実行できるようにする。

    // コードの可読性、保守性などを大幅に引き上げる。

    // 基本構文
    // function 関数名(){
    //    処理
    // }

    function gedFullName(){
      // ユーザーのフルネームを返す関数
      $first_name = "hiroki";
      $last_name = "shimada";
      $full_name = $first_name ." ". $last_name;
      echo $full_name;
    }

    getFullName();

    // 引数付きの関数
    // 引数とは
    // 関数名の後の()内に指定された変数

    // 基本構文
    // function 関数名(第一引数、第二引数、第三引数...){
    //    処理
    //    ※ 引数は関数内でのみ使用可
    // }

    // 引数付き関数定義
    function getFullName2($first, $last){
        $first_name = $first;
        $last_name = $last;
        $full_name = $first_name ." ". $last_name;
        echo $full_name;
    }

    // getFullName2の実行
    getFullName2("shinya","hirai");
    getFullName2("shimada","hiroki");

    // 返り値付きの関数
    // 関数の処理内の最後にreturnがある場合は返り値ありの関数
    // 関数を実行した際に何か値を返してくれる


?>
