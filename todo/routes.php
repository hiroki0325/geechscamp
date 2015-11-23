<?php
    //// +++ DB接続 +++ ////
    require('dbconnect.php');

    //// +++セッションの利用 +++ ////
    session_start();

    //// +++ function.phpの呼び出し +++ ////
    require('function.php');

    //// +++ ルーティング +++ ////
    $params = explode('/', $_GET['url']);

    $resource = $params[0];
    $action = $params[1];

    if (count($params) > 2) {
        $id = $params[2];
    }

    // リソース名を複数形に変換する処理
    $plural_resorce = singular2plural($resource);

    // model呼び出す
    include('./models/' . $resource . '.php');

    // controller呼び出す
    include('./controllers/' . $plural_resorce . '_contllorer.php');

    // アクション名がcreateなら新規作成処理をする
    if ($action == 'create') {
        if ($resource == 'category') {
            $CategoriesController = new CategoriesController($db, $plural_resorce);
            $CategoriesController->create();
        }
    }

    // アクション名がupdateならアップデート処理をする
    if ($action == 'update') {
        if ($resource == 'category') {
            $CategoriesController = new CategoriesController($db, $plural_resorce);
            $CategoriesController->update();
        }
    }

    // アクション名がdeleteなら削除処理する
    if ($action == 'delete') {
        if ($resource == 'category') {
            $CategoriesController = new CategoriesController($db, $plural_resorce);
            $CategoriesController->delete();
        }
    }

    // viewの形成を楽にするヘルパーを読み込み
    include('./views/helpers/application_helper.php');

    // レイアウトファイルを読み込み
    include('./views/layouts/application.php');

?>
