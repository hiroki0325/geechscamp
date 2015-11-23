<?php

// 数値型の演算

// + - * / % **(PHP5.6-)

//$x = 10 % 3; //1
//$y = 30.2 / 4; //7.55
//var_dump($x);
//var_dump($y);

// 単項演算子 ++ --
//$z =5;
//$z++; //6
//var_dump($z);
//$z--; //5
//var_dump($z);

//代入を伴う演算子
//$x = 5;
//$x = $x * 2
//$x *= 2; //10
//var_dump($x);

//文字列
//""特殊文字(\n, \t) 変数
//''

//$name = "taguchi";
//$s1 = "hello {$name}!\nhello again!";
//$s2 = 'hello $name!\nhello again!';
//var_dump($s1);
//var_dump($s2);

// 連結 . 
//$s = "hello "."world";
//var_dump($s);

//if 条件分岐
//比較演算子 > < >= <= == === != !==
//論理演算子 and && , or || , !

//$score = 40;

//if ($score > 80){
//	echo "great!";
//} elseif ($score > 60) {
//	echo "good!";
//} else {
//	echo "so so ...";
//}

//真偽値
/*
# falseになる場合
文字列：空、"0"
論理値：0、0.0
論理値：false
配列：要素の数が0
null
*/

//$x = 5;
//if ($x) {
//if ($x == true){
//	echo "great";
//}

//参考演算子
//$a = 4;
//$b = 5;
//
//$max = ($a > $b) ? $a : $b;
//var_dump($max);
//if ($a > $b){
//	$max = $b;
//}
//var_dump($max);

// switch 条件分岐
//$signal = "no";

//switch ($signal){
//			case "red";
//				echo "stop!";
//				break;
//			case "blue";
//			case "green";
//				echo "go!";
//				break;
//			case "yellow";
//			case "no";
//				echo "caution!";
//				break;
//			default;
//				echo "wrong signal";
//				break;
//	}
//
// ループ処理
// while
// do ... while

//$i = 0;
//while ($i < 10){
//		echo $i;
//		$i++;
//}
//
// do ... while文は後に判定が走る（少なくとも1回は処理が実行される）
//do {
//	echo $i;
//	$i++;
//} while ($i < 10 );
//

// 配列
// key value

//$sales = array(
//	"taguchi" => 200,
//	"fkoji" => 800,
//	"dotinstall" => 600,
// );

// PHP5.4
//$sales = [
//	"taguchi" => 200,
//	"fkoji" => 800,
//	"dotinstall" => 600,
// ];
//
// var_dump($sales["fkoji"]); //800
// $sales["fkoji"] = 900;
// var_dump($sales["fkoji"]); //900

//foreach ($sales as $key => $value){
//	echo "($key) $value ";
//}

// $colors = ["red","blue","pink"];
// var_dump($colors[1]); //blue
// foreach ($colors as $value){
//	echo "$value ";							
//}

// foreach if while for コロン構文
// foreach ($colors as $value):
//				 echo "$value ";
// endforeach;

// 関数

function sayHi($name = "taguchi") {
	//echo "hi!".$name;
	return "hi! ".$name;
}

//sayHi("Tom");
//sayHi("Bob");
//sayHi();

$s = sayHi();
var_dump($s);

?>
