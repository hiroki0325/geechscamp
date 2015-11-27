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

              // ユーザー名の取得（表示用）
              $sql = $Task->findUser();
              $record = mysqli_query($this->db,$sql) or die(mysqli_error($this->db));
              $user = mysqli_fetch_assoc($record);

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

        public function create(){
            $Task = new Task($this->db,$this->plural_resorce);
            // タスクを記録する
            if (isset($_POST['task_title']) && $_POST['task_title'] != '') {
                $sql = $Task->createTask();
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            }
            header('Location: index');
            exit();
        }

        public function finishTasks(){
            $Task = new Task($this->db,$this->plural_resorce);
            if (isset($_SESSION['id'])) {
                $id = $_SESSION['id'];

                // タスクを一旦全部取り出す
                $sql = $Task->findAllTasks($id);
                $record = mysqli_query($this->db, $sql);

                while ($table = mysqli_fetch_assoc($record)) {
                    // チェックされたもののみに処理を行う
                    $taskId = $table['id'];
                    $sql = $Task->finishTasks($taskId);
                    mysqli_query($this->db, $sql)  or die(mysqli_error($this->db));
                }
            }
            if (isset($_POST['category_id'])) {
                $param = $_POST['category_id'];
                header("Location: ../task/index?category_id={$param}");
                exit();
            } else {
                header('Location: ../task/index');
                exit();
            }
        }

        public function update(){
            $Task = new Task($this->db,$this->plural_resorce);

            // 情報が送信された後なら、このあとの処理を実行する
            if (isset($_POST['modified_title'])) {

                // 送信内容の検査
                if ($_POST['deadline'] =='') {
                  $_POST['deadline'] ="NULL";
                }else{
                  $_POST['deadline'] = mysqli_real_escape_string($this->db, $_POST['deadline']);
                  $_POST['deadline'] ='"'.$_POST['deadline'].'"';
                }

                // タスク内容のアップデート処理を実行
                $sql = $Task->update();
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                if ($_POST['category_id_for_index'] !="") {
                    $param = $_POST['category_id_for_index'];
                    header("Location: ../task/index?category_id={$param}");
                    exit();
                } else {
                    header('Location: ../task/index');
                    exit();
                }
            }
        }

        public function delete(){
            $Task = new Task($this->db,$this->plural_resorce);
            $id = $_REQUEST['task_id'];

            // タスクを検査する(本当にユーザー自身のタスクかどうか)
            $sql = $Task->check($id);
            $record = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            $table = mysqli_fetch_assoc($record);
            if ($table['user_id'] == $_SESSION['id']) {
                // タスクの削除
                $sql = $Task->delete($id);
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            }
            header('Location: ../task/index');
            exit();
        }

    }

?>
