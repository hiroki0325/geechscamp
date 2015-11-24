<?php
    class usersController{
        // プロパティを定義
        private $db;
        private $plural_resorce;

        // マジックメソッド(引数2つ)
        public function __construct($db, $plural_resorce){
          $this->db = $db;
          $this->plural_resorce = $plural_resorce;
        }

        public function _new(){
            if (!empty($_POST)) {
                // エラー項目の確認
                if ($_POST['name'] =='') {
                    $error['name'] = 'blank' ;
                }
                if (strlen($_POST['password']) < 4 ) {
                   $error['password'] = 'length' ;
                }
                if ($_POST['password'] =='') {
                    $error['password'] = 'blank' ;
                }
                if ($_POST['password'] != $_POST['password2']) {
                   $error['password'] = 'notsame' ;
                }

                // 重複アカウントのチェック
                if (!empty($_POST)) {
                    if (empty($error)) {
                        $User = new User($this->db, $this->plural_resorce);
                        $sql = $User->countByName();
                        $record = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                        $table = mysqli_fetch_assoc($record);
                        if ($table['cnt'] > 0 ){
                            $error['name'] = 'duplicate';
                        }
                    }
                }

                if (empty($error)) {
                    // 登録処理をする
                    $sql = $User->create();
                    mysqli_query($this->db, $sql) or die(mysqli_error($this->db));

                    // ログイン情報をセッションに入れる
                    $sql = $User->findByName();
                    $users = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
                    $user = mysqli_fetch_assoc($users);
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['time'] = time();
                    header('Location: thanks');
                    exit();
                } else {
                    return $error;
                }
            }
        }

    }

?>
