<?php
    class User {

        // privateなプロパティを定義
        private $plural_resorce = '';
        private $db ='';

        public function __construct($db, $plural_resorce) {
            $this->db = $db;
            $this->plural_resorce = $plural_resorce;
        }

        public function findByName(){
            $sql = sprintf('SELECT COUNT(*) AS cnt FROM %s WHERE name="%s"',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $_POST["name"])
            );
            return $sql;
        }

        public function create(){
            $sql = sprintf('INSERT INTO %s SET name="%s", password="%s", created=NOW()',
                  $this->plural_resorce,
                  mysqli_real_escape_string($this->db, $_POST['name']),
                  mysqli_real_escape_string($this->db, sha1($_POST['password']))
                    );
            return $sql;
        }

    }
?>
