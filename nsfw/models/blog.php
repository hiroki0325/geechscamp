<?php
    class Blog {
        // DB内のblogsテーブルとのデータのやりとりを担当するファイル
        // echo "blog model file";

        // modelファイルは単に最適なsql文を返すファイル

        // privateなプロパティを定義
        private $plural_resorce = '';
        public function __construct($plural_resorce) {
            $this->plural_resorce = $plural_resorce;
        }

        public function findAll(){
            // データを取得する(model)
            $sql = 'SELECT * FROM ' . $this->plural_resorce;
            return $sql;
        }
    }
?>
