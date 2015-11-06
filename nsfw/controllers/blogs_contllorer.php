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

        public function show($id){
            $Blog = new Blog($this->plural_resorce);
            $sql = $Blog->findById($id);

            $blog = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
            return $blog;
        }

        public function _new($blog){
            // 予約後
            // プログラミング言語には、言語ごとにあらかじめ使われている変数や関数の名前があり、
            // 同じ名前を開発者が使用することができません。
            // こういった名前のことを予約後と言う。

            if (!empty($blog)) {
                $Blog = new Blog($this->plural_resorce);
                $sql = $Blog->create($blog);

                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

                header('Location:index');
            }
        }

        public function edit($blog, $id){

            if (empty($blog)) {
                // ページに初めて訪れた際
                $blog_record = $this->show($id);
                $blog = mysqli_fetch_assoc($blog_record);

                return $blog;

            } elseif(!empty($blog)) {
                // 情報を編集し送信した際
                $id = array('id' => $id);
                $blog = array_merge($id, $blog);

                $Blog  = new Blog($this->plural_resorce);
                $sql = $Blog->update($blog);

                mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                header('Location: ../index');
            }
        }

        public function delete($id){
            $Blog  = new Blog($this->plural_resorce);
            $sql = $Blog->destroy($id);

            mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

            header('Location: ../index');
        }
    }

?>
