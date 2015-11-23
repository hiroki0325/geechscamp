<?php
    class CategoriesController{
        // プロパティ
        private $db;
        private $plural_resorce;

        // マジックメソッド(引数2つ)
        public function __construct($db, $plural_resorce){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
        }

        // 新規カテゴリの作成メソッド
        public function create(){
            $Category = new Category($this->db,$this->plural_resorce);
            if (isset($_POST['category_name']) && $_POST['category_name'] != '') {
                $id = $_SESSION['id'];
                $sql = $Category->create($id);
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            }
            header('Location: ../task/index');
            exit();
        }

        // 既存カテゴリの更新メソッド
        public function update(){
            $Category = new Category($this->db,$this->plural_resorce);
            if ($_POST['edited_categoryname'] !='') {
                $Category = new Category($this->db,$this->plural_resorce);
                $sql = $Category->update();
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
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

        // カテゴリの削除メソッド
        public function delete(){
            $Category = new Category($this->db,$this->plural_resorce);
            if (isset($_REQUEST['category_id'])) {
                $user_id = $_SESSION['id'];
                $category_id = $_REQUEST['category_id'];

                // カテゴリーを検査する(本当にユーザー自身のカテゴリかどうか)
                $sql = $Category->check($category_id);
                $record = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                $table = mysqli_fetch_assoc($record);

                // 本当にユーザー自身のカテゴリだったら
                if ($table['user_id'] == $user_id) {
                    // カテゴリーの削除
                    $sql = $Category->delete($category_id);
                    mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

                    // 削除したカテゴリーが設定されていたToDoのカテゴリ情報をクリア
                    $sql = $Category->clear($category_id);
                    mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                }
            }

            header('Location: ../task/index');
            exit();
        }

    }

?>
