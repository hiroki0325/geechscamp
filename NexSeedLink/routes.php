<?php
    //// +++ DB接続 +++ ////
    require('dbconnect.php');

    //// +++ function.phpの呼び出し +++ ////
    include('function.php');

    //// +++ ルーティング +++ ////
    $params = explode('/', $_GET['url']);

    $function = $params[0];
    $directry = $params[1];
    $page = $params[2];

    if (count($params) > 3) {
        $id = $params[3];
    }

    // リソース名を複数形に変換する処理
    $plural_resorce = singular2plural($resource);

    // viewの形成を楽にするヘルパーを読み込み
    // include('./views/helpers/application_helper.php');

    // レイアウトファイルを読み込み
    include('./views/layouts/application.php');

?>
