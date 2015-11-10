<?php
  // htmlspecialchars のショートカット
  function h($value){
    return htmlspecialchars($value, ENT_QUOTES,'UTF-8');
  }

  // 期限切れタスクの件数表示ファンクション
   function cnt($db, $category){
   $sql = sprintf('SELECT COUNT(*) AS cnt FROM tasks WHERE deadline < NOW() AND category_id=%d AND finish_flg=0',
         $category['id']
     );
   $cnt = mysqli_query($db, $sql) or die(mysqli_error($db));
   $task = mysqli_fetch_assoc($cnt);
   return $task;
   }
 ?>
