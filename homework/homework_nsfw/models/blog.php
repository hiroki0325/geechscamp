<?php
    class Blog {
        // DB内のblogsテーブルとのデータのやりとりを担当するファイル
        // echo "blog model file";

        // modelファイルは単に最適なsql文を返すファイル

        // privateなプロパティを定義
        private $plural_resorce = '';
        private $option = '';
        private $db = '';
        public function __construct($plural_resorce, $option, $db) {
            $this->plural_resorce = $plural_resorce;
            $this->option = $option;
            $this->db = $db;
        }

        public function findAll(){
            // データを取得する(model)
            $sql = 'SELECT * FROM ' . $this->plural_resorce;
            return $sql;
        }

        public function findOne(){
            $sql = 'SELECT * FROM ' . $this->plural_resorce . ' WHERE id='. $this->option;
            return $sql;
        }

        public function create(){
            $sql = sprintf('INSERT INTO blogs SET title="%s", body="%s", created=NOW()',
                    // ToDo mysqli_real_escape_stringはmodelとcontllorerどっちの役割なのだろうか？
                    mysqli_real_escape_string($this->db, $_POST['title']),
                    mysqli_real_escape_string($this->db, $_POST['body'])
                );
            return $sql;
        }

        public function update($blog,$id){
            $sql = sprintf('UPDATE %s SET title="%s", body="%s", modified=NOW() WHERE id=%d',
                    $this->plural_resorce,
                    mysqli_real_escape_string($this->db, $blog['title']),
                    mysqli_real_escape_string($this->db, $blog['body']),
                    $id
                );
            return $sql;
        }

        public function delete(){
            $sql = sprintf('DELETE FROM '. $this->plural_resorce .' WHERE id=%d',
                mysqli_real_escape_string($this->db, $this->option)
                );
            return $sql;
        }
    }
?>
