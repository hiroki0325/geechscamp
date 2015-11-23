<?php

    /*
		変数:データにつけるラベル
		
		データ型：
		- 文字列 string
		- 数値 integer float
		- 論理値 boolean / true false
		- 配列
		- オブジェクト
		- null
		*/

		$msg = "hello from the TOP!";
    echo $msg;
		var_dump($msg);

		//定数: 変更されない値につけるラベル

		define("MY_EMAIL","taguchi@dotinstall.com");

		echo MY_EMAIL;

		var_dump(__LINE__); // 25
		var_dump(__FILE__);
		var_dump(__DIR__);
