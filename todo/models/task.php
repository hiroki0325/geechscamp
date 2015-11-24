<?php
    class Task {
        // プロパティを定義
        private $plural_resorce = '';
        private $db;

        // マジックメソッド
        public function __construct($db, $plural_resorce){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
        }

        public function createTask(){
            $sql = sprintf('INSERT INTO %s SET user_id=%d, title="%s", category_id=%d, created=NOW()',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $_SESSION['id']),
                mysqli_real_escape_string($this->db, $_POST['task_title']),
                mysqli_real_escape_string($this->db, $_POST['category_id'])
            );
            return $sql;
        }

        public function findCurrentCategory(){
            $sql = sprintf('SELECT name FROM categories WHERE id=%d',
                mysqli_real_escape_string($this->db, $_REQUEST['category_id'])
              );
            return $sql;
        }

        public function findUser(){
            $sql = sprintf('SELECT * FROM users WHERE id=%d',
              mysqli_real_escape_string($this->db,$_SESSION['id'])
              );
            return $sql;
        }

        public function findAllTasks($id){
            $sql = sprintf('SELECT id FROM %s WHERE user_id=%d',
                $this->plural_resorce,
                mysqli_real_escape_string($this->db, $id)
            );
            return $sql;
        }

        public function findUnfinishedTasks(){
            if (!isset($_SESSION['category_id'])) {
                $sql = sprintf('SELECT * FROM %s WHERE user_id=%d AND finish_flg=0 ORDER BY created DESC',
                    $this->plural_resorce,
                    mysqli_real_escape_string($this->db, $_SESSION['id'])
                );
            }else{
                $sql = sprintf('SELECT * FROM %s WHERE user_id=%d AND category_id=%d AND finish_flg=0 ORDER BY created DESC',
                    $this->plural_resorce,
                    mysqli_real_escape_string($this->db, $_SESSION['id']),
                    mysqli_real_escape_string($this->db, $_SESSION['category_id'])
                );
            }
            return $sql;
        }

        public function findFinishedTasks(){
            if (!isset($_SESSION['category_id'])) {
                $sql = sprintf('SELECT * FROM %s WHERE user_id=%d AND finish_flg=1 ORDER BY created DESC',
                    $this->plural_resorce,
                    mysqli_real_escape_string($this->db, $_SESSION['id'])
                );
            }else{
                $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND category_id=%d AND finish_flg=1 ORDER BY created DESC',
                    mysqli_real_escape_string($this->db, $_SESSION['id']),
                    mysqli_real_escape_string($this->db, $_SESSION['category_id'])
                );
            }
            return $sql;
        }

        public function findMyCategories(){
            $sql = sprintf('SELECT * FROM categories WHERE user_id=%d',
              mysqli_real_escape_string($this->db, $_SESSION['id'])
              );
            return $sql;
        }

        public function finishTasks($taskId){
            if (isset($_POST['category_id'])) {
                if (isset($_POST["$taskId"])) {
                    $sql = sprintf('UPDATE %s SET finish_flg=1 WHERE id=%d AND category_id=%d',
                        $this->plural_resorce,
                        mysqli_real_escape_string($this->db, $taskId),
                        mysqli_real_escape_string($this->db, $_POST['category_id'])
                    );
                }else{
                    $sql = sprintf('UPDATE %s SET finish_flg=0 WHERE id=%d AND category_id=%d',
                        $this->plural_resorce,
                        mysqli_real_escape_string($this->db, $taskId),
                        mysqli_real_escape_string($this->db, $_POST['category_id'])
                    );
                }
            } else {
                if (isset($_POST["$taskId"])) {
                    $sql = sprintf('UPDATE %s SET finish_flg=1 WHERE id=%d',
                        $this->plural_resorce,
                        mysqli_real_escape_string($this->db, $taskId)
                    );
                }else{
                    $sql = sprintf('UPDATE %s SET finish_flg=0 WHERE id=%d',
                        $this->plural_resorce,
                        mysqli_real_escape_string($this->db, $taskId)
                    );
                }
            }
            return $sql;
        }
    }
?>
