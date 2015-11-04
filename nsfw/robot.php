<?php
    // ネコ型ロボットの設計図
    class Robot {
        // プロパティ定義
        // publicとは
        // アクセス権を表現するためのキーワード
        // publicはどこからでもアクセスが可能なプロパティであることを意味する。
        // プロパティの定義には、必ずこのアクセス権の明示が必要。
        // publicアクセス権の反対の意味でprivateがある。

        // public $name; // null
        // public $name = ''; // $nameプロパティには文字列が入ることを期待

        // カプセル化
        // 外部からのアクセスを禁止し、内部に隠蔽してしますことをカプセル化と言う。
        private $name = '';

        // マジックメソッド
        // __constructを利用する
        public function __construct($name) {
            $this->setName($name);
        }

        // Getter/Setterパターン
        public function setName($name) {
          // $this は 自分自身
            $this->name = $name;
        }

        public function getName(){
            return $this->name;
        }
        // オブジェクト指向
        // 特長
        // 1.外部には機能的にまとめられた最低限必要な情報しか公開しない。
        // 2.ライブラリ開発や複数人での開発に向いている。
        // 3.大規模になってきてもメンテナンスがしやすい。

    }
?>
