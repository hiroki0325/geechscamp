<?php
    class BlogsController{
        // データなどを処理する(controller)

        // プロパティ
        private $db;
        private $plural_resorce;

        // マジックメソッド(引数2つ)
        public function __construct($db, $plural_resorce){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
        }

        public function index(){
            // Blogクラスから$Blogインスタンス生成
            $Blog = new Blog($this->plural_resorce);
            $sql = $Blog->findAll(); // 'SELECT * FROM blogs'という文字列が返ってくる

            $blogs = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            return $blogs;
        }
    }

?>
