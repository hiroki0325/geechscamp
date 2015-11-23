<?php
    class Category {

        // privateなプロパティを定義
        private $plural_resorce = '';
        public function __construct($db,$plural_resorce) {
            $this->db = $db;
            $this->plural_resorce = $plural_resorce;
        }

        // カテゴリを新規作成するSQL文を返すメソッド
        public function create(){
            $sql = sprintf('INSERT INTO %s SET user_id=%d, name="%s", created=NOW()',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $_SESSION['id']),
                mysqli_real_escape_string($this->db, $_POST['category_name'])
            );
            return $sql;
        }

        // カテゴリ名の編集用SQL文を返すメソッド
        public function update(){
            $sql = sprintf('UPDATE %s SET name="%s" WHERE id=%d',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $_POST['edited_categoryname']),
                mysqli_real_escape_string($this->db, $_POST['category_id'])
            );
            return $sql;
        }

        // カテゴリ削除時にそのカテゴリが本当にユーザー自身のカテゴリかどうかを確認するSQL文を返すメソッド
        public function check($id){
            $sql = sprintf('SELECT * FROM %s WHERE id=%d',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $id)
            );
            return $sql;
        }

        // カテゴリを削除するSQL文を返すメソッド
        public function delete($id){
            $sql = sprintf('DELETE FROM %s WHERE id=%d',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $id)
            );
            return $sql;
        }

        // 削除したカテゴリに紐付いていたタスクのカテゴリ設定を初期化するSQL文を返すメソッド
        public function clear($id){
            $sql = sprintf('UPDATE tasks SET category_id=0 WHERE category_id=%d',
                mysqli_real_escape_string($this->db, $id)
            );
            return $sql;
        }

    }

?>
