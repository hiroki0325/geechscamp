<?php
    class BlogsController{
        // データなどを処理する(controller)

        // プロパティ
        private $db;
        private $plural_resorce;
        private $option;

        // マジックメソッド(引数2つ)
        public function __construct($db, $plural_resorce, $option){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
          $this->option = $option;
        }

        public function index(){
            // Blogクラスから$Blogインスタンス生成
            $Blog = new Blog($this->plural_resorce, $this->option, $this->db);
            $sql = $Blog->findAll(); // 'SELECT * FROM blogs'という文字列が返ってくる

            $blogs = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

            return $blogs;
        }

        public function show(){
            $Blog = new Blog($this->plural_resorce, $this->option, $this->db);
            $sql = $Blog->findOne();

            $blogs = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

            return $blogs;
        }

        public function _new(){
            // まずユーザーから送られてきた情報をチェック
            if(isset($_POST['title'])){
                if ($_POST['title'] == '') {
                    $error['title'] = 'empty';
                    // たぶん本当はやっちゃいけないヤツ
                    $_POST['title'] = 'empty';
                }

                if ($_POST['body'] =='') {
                    $error['body'] = 'empty';
                    $_POST['body'] ='empty';
                }

            if (empty($error)) {
                // 問題なければmodelを呼び出してSQL文を発行して実行する
                $Blog = new Blog($this->plural_resorce, $this->option, $this->db);
                $sql = $Blog->create();
                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                header('Location:index');
                exit();
                  }
            }
        }
        public function delete(){
            $Blog = new Blog($this->plural_resorce, $this->option, $this->db);
            $sql = $Blog->delete();
            var_dump($sql);
            mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            header('Location:../index');
            exit();
        }
    }


?>
