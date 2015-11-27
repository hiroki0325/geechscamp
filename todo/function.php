<?php
  // htmlspecialchars のショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES,'UTF-8');
  }

  // 詳細内のURLにリンクを設定する
  function makeLink($value){
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>', $value);
  }

  // 未完了タスクの件数表示ファンクション
   function countUnfinishedTaskInCategory($db, $category){
   $sql = sprintf('SELECT COUNT(*) AS cnt FROM tasks WHERE category_id=%d AND finish_flg=0',
         $category['id']
     );
   $cnt = mysqli_query($db, $sql) or die(mysqli_error($db));
   $task = mysqli_fetch_assoc($cnt);
   return $task;
   }

   // 誤入力時等の入力補助
       function fillout($name){
           if (isset($_POST["$name"])){
               echo sprintf('<input type="text" name="'.$name.'" size="35" maxlength="255" value="%s" >' ,
               h($_POST["$name"]));
           } else {
               echo '<input type="text" name="'.$name.'" size="35" maxlength="255">' ;
           }
       }

   // 単数形resource名の単語を複数形に変換する関数
   function singular2plural($singular) {
       $dictionary = array(
           'man' => 'men',
           'seaman' => 'seamen',
           'snowman' => 'snowmen',
           'woman' => 'women',
           'person' => 'people',
           'child' => 'children',
           'foot' => 'feet',
           'crux' => 'cruces',
           'oasis' => 'oases',
           'phenomenon' => 'phenomena',
           'tooth' => 'teeth',
           'goose' => 'geese',
           'genus' => 'genera',
           'graffito' => 'graffiti',
           'mythos' => 'mythoi',
           'numen' => 'numina',
           'equipment' => 'equipment',
           'information' => 'information',
           'rice' => 'rice',
           'money' => 'money',
           'species' => 'species',
           'series' => 'series',
           'fish' => 'fish',
           'sheep' => 'sheep',
           'swiss' => 'swiss',
           'chief' => 'chiefs',
           'cliff' => 'cliffs',
           'proof' => 'proofs',
           'reef' => 'reefs',
           'relief' => 'reliefs',
           'roof' => 'roofs',
           'piano' => 'pianos',
           'photo' => 'photos',
           'safe' => 'safes'
       );

       if (array_key_exists($singular, $dictionary)) {
           $plural = $dictionary[$singular];
       } elseif (preg_match('/(a|i|u|e|o)o$/', $singular)) {
           $plural = $singular . "s";
       } elseif (preg_match('/(s|x|sh|ch|o)$/', $singular)) {
           $plural = preg_replace('/(s|x|sh|ch|o)$/', '$1es', $singular);
       } elseif (preg_match('/(b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z)y$/', $singular)) {
           $plural = preg_replace('/(b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|v|w|x|y|z)y$/', '$1ies', $singular);
       } elseif (preg_match('/(f|fe)$/', $singular)) {
           $plural = preg_replace('/(f|fe)$/', 'ves', $singular);
       } else {
           $plural = $singular . "s";
       }
       return $plural;
   }

   // タスク編集用のjavascript生成ファンクション
   // function editTask(){

   // }


 ?>
