<?php
    class TasksController{
        // プロパティを定義
        private $db;
        private $plural_resorce;

        // マジックメソッド
        public function __construct($db, $plural_resorce){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
        }

        public function index(){
            $Task = new Task($this->db,$this->plural_resorce);

              // カテゴリが選択されていたら、カテゴリ情報をセッションに保存
              if (isset($_REQUEST['category_id'])) {
                  $_SESSION['category_id'] = $_REQUEST['category_id'];
                  $sql = $Task->findCurrentCategory();
                  $category = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                  $category = mysqli_fetch_assoc($category);
                  $_SESSION['category_name'] = $category['name'];
              }else{
                // カテゴリが選択されていなかったら、カテゴリ関連のセッション情報をクリア
                $_SESSION['category_id'] = NULL;
                $_SESSION['category_name'] = NULL;
                $_SESSION['category'] = NULL;
              }

              // ログイン判定
              if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
                // ログインしている
                $_SESSION['time'] = time();
                $sql = $Task->findUser();
                $record = mysqli_query($this->db,$sql) or die(mysqli_error($this->db));
                $user = mysqli_fetch_assoc($record);
              } else {
                // ログインしてない
                header('Location:../user/login');
                exit();
              }

              //未完了タスクを取得する(表示用)
              $sql = $Task->findUnfinishedTasks();
              $unfinishedTasks = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

              // 完了タスクを取得する(表示用)
              $sql = $Task->findFinishedTasks();
              $finishedTasks = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

              // カテゴリ一覧を取得する(表示用)
              $sql = $Task->findMyCategories();
              $myCategories = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

              return array($user,$unfinishedTasks,$finishedTasks,$myCategories);
        }

    }

?>
