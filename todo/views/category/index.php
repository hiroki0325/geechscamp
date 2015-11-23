<?php
  // 詳細内のURLにリンクを設定する
  function makeLink($value){
    return mb_ereg_replace("(https?)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)",'<a href="\1\2">\1\2</a>', $value);
  }

  // カテゴリが選択されていたら、カテゴリ情報をセッションに保存
  if (isset($_REQUEST['category_id'])) {
    $_SESSION['category_id'] = $_REQUEST['category_id'];
    $sql = sprintf('SELECT name FROM categories WHERE id=%d',
        mysqli_real_escape_string($db, $_REQUEST['category_id'])
      );
     $category = mysqli_query($db, $sql) or die(mysqli_error($db));
     $category = mysqli_fetch_assoc($category);
     $_SESSION['category_name'] = $category['name'];
  }else{
    // カテゴリが選択されていなかったら、セッション情報をクリア
    $_SESSION['category_id'] = NULL;
    $_SESSION['category_name'] = NULL;
    $_SESSION['category'] = NULL;
  }

  if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    # ログインしている
    $_SESSION['time'] = time();

    $sql = sprintf('SELECT * FROM users WHERE id=%d',
      mysqli_real_escape_string($db,$_SESSION['id'])
      );
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);
  } else {
    // ログインしてない
    header('Location:login.php');
    exit();
  }

  //未完了タスクを取得する
  if (!isset($_SESSION['category_id'])) {
    $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND finish_flg=0 ORDER BY created DESC',
      mysqli_real_escape_string($db, $_SESSION['id'])
      );
  }else{
    $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND category_id=%d AND finish_flg=0 ORDER BY created DESC',
      mysqli_real_escape_string($db, $_SESSION['id']),
      mysqli_real_escape_string($db, $_SESSION['category_id'])
      );
  }

  $tasks = mysqli_query($db, $sql) or die(mysqli_error($db));

  // 完了タスクを取得する
  if (!isset($_SESSION['category_id'])) {
    $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND finish_flg=1 ORDER BY created DESC',
      mysqli_real_escape_string($db, $_SESSION['id'])
      );
  }else{
    $sql = sprintf('SELECT * FROM tasks WHERE user_id=%d AND category_id=%d AND finish_flg=1 ORDER BY created DESC',
      mysqli_real_escape_string($db, $_SESSION['id']),
      mysqli_real_escape_string($db, $_SESSION['category_id'])
      );
  }
  $finishedTasks = mysqli_query($db, $sql) or die(mysqli_error($db));

  // カテゴリを取得する
  $sql = sprintf('SELECT * FROM categories WHERE user_id=%d',
    mysqli_real_escape_string($db, $_SESSION['id'])
    );
  $categories = mysqli_query($db, $sql) or die(mysqli_error($db));

?>

  <div class="container">

    <!-- 1行目 -->
    <div class="row">

      <!-- カテゴリパート -->
      <div class="col-sm-3" style="text-align: center;">
        こんにちは、<?php echo $member['name']; ?>さん
      </div>

      <!-- タスクパート -->
      <div class="col-sm-9">
        <div class="col-sm-10">
          <span style="margin: 0px 0px 0px -2px;">
            <?php if (isset($_SESSION['category_name'])): ?>
              <?php echo $_SESSION['category_name']; ?>
            <?php else: ?>
              タスク一覧
            <?php endif; ?>
          </span>
          <div class="input-group" style="float: right;">
            <form action="" method="get">
              <input type="text" class="form-control" name="search" placeholder="タスクを検索" style="width:160px; height:27px;" >
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
              </span>
            </form>
          </div>
        </div>
        <div class="col-sm-2">
          <p>
            <i class="fa fa-sort-alpha-asc" style="font-size: 20px;"></i>
            <i class="fa fa-cog" style="font-size: 20px;"></i>
          </p>
        </div>
      </div>

    </div>

    <!-- 2行目 -->
    <div class="row">

      <!-- カテゴリセクション -->
      <div class="col-xs-3">

        <!-- 受信箱 -->
        <div class="panel-group" id="accordion">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a href="index.php">
                  <i class="fa fa-folder-open-o"></i>タスク一覧
                </a><br>
              </h4>
            </div>

            <!-- カテゴリ一覧を表示 -->
            <div id="collapseOne" class="panel-collapse collapse in">
              <div class="panel-body">
                <table class="table">
                  <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                    <tr>
                      <td>
                        <a href="index.php?category_id=<?php echo $category['id']; ?>">
                          <i class="fa fa-file-text-o"></i>
                          <?php  echo $category['name']; ?>
                        </a>
                        <?php $task = cnt($db, $category);?>
                        <?php if($task['cnt'] != 0){ ?>
                          <span class="badge">
                            <?php echo $task['cnt']; ?>
                          </span>
                        <?php } ?>
                        <span style="float: right">
                          <a href="index.php?action=edit&category_id=<?php echo $category['id']; ?>"><i class="fa fa-pencil-square-o"></i></a> <a href="category/delete.php?category_id=<?php echo $category['id']; ?>"><i class="fa fa-ban"></i></a>
                        </span>
                        <br>
                        <?php if (isset($_REQUEST['action']) && isset($_REQUEST['category_id'] )): ?>
                          <?php if ($_REQUEST['action']=='edit' && $_REQUEST['category_id'] == $category['id']): ?>
                            <form action="category/update.php" method="post">
                              <input type="text" name="edited_categoryname" placeholder="カテゴリ名">
                              <?php  if (isset($_SESSION['category_id'])) { ?>
                              <input type="hidden" name="category_id" value="<?php echo $_SESSION['category_id']; ?>">
                              <?php }?>
                              <input type="submit" value="変更">
                            </form>
                          <?php endif; ?>
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php } ?>
                  </form>
                </table>
              </div>
            </div>

            <!-- 新しいカテゴリを作成する -->
            <div class="panel-heading">
              <h4 class="panel-title">
                <form action="category/create.php" method="post" accept-charset="utf-8">
                  <input type="text" name="category_name" style="width:180px;" placeholder="新しいカテゴリ名">
                  <span style="float: right">
                    <input type="submit" value="作成"  >
                  </span>
                </form>
              </h4>
            </div>
          </div>
        </div>
      </div>

      <!-- タスクを追加する -->
      <div class="col-xs-9">
        <form action="task/create.php" method="POST" accept-charset="utf-8">
          <div class="col-sm-10">
            <span style="float: left;">
              <input type="text" name="task_title" placeholder="新しいToDoを入力" class="form-control add-todo" style="margin: 0px 0px 0px -15px; width: 445px;">
            </span>
            <span style="float: right;">
              <select name="category_id" style="height: 25px; font-size: 30px; margin-top: 2px; ">
                <option value="">カテゴリを選択してください</option>
                <?php mysqli_data_seek($categories, 0); ?>
                <?php while ($category = mysqli_fetch_assoc($categories)) { ?>
                  <option value="<?php echo $category['id'] ?>"><?php echo $category['name'] ?></option>
                <?php } ?>
              </select>
            </span>
          </div>
          <div class="col-sm-2">
            <button type="submit" class="btn btn-success">ToDoを追加する</button>
          </div>
        </form>
      </div>

      <!-- タスクセクション -->
      <div class="col-xs-9">
        <form action="task/finish.php" method="post" accept-charset="utf-8">

          <!-- 未完了タスク -->
          <hr>
          <div class="todolist not-done">
            <ul id="sortable" class="list-unstyled">
              <?php while ($task = mysqli_fetch_assoc($tasks)) { ?>
                <div class="checkbox" style="border-bottom:1px solid #ddd;">
                  <li class="ui-state-default">
                    <input type="checkbox" name="<?php echo $task['id'] ?>" value="finish">
                    <span>
                      <?php  echo $task['title']; ?>
                      <?php if( $task['deadline'] !='' &&$task['deadline'] < date('Y-m-d')){ ?>
                      <i class="fa fa-exclamation-triangle"></i>
                      <?php } ?>
                    </span>
                  </li>
                  <span style="float: right"><a href="task/update.php?task_id=<?php echo $task['id']; ?>"><i class="fa fa-pencil-square-o"></i></a> <a href="task/delete.php?task_id=<?php echo $task['id']; ?>">
                    <i class="fa fa-ban"></i></a>
                  </span>
                </div>
              <?php } ?>
            </ul>
          </div>

          <!-- 完了済タスク -->
          <div class="todolist">
            <ul id="done-items" class="list-unstyled">
              <?php while ($finishedTask = mysqli_fetch_assoc($finishedTasks)) { ?>
                <div class="checkbox" style="border-bottom:1px solid #ddd;" >
                  <li>
                    <input type="checkbox" name="<?php echo $finishedTask['id']; ?>" value="finish" checked="checked">
                    <span style="color:#A9A9A9"><?php  echo $finishedTask['title']; ?></span>
                  </li>
                  <span style="float: right">
                    <a href="task/update.php?task_id=<?php echo $finishedTask['id']; ?>"><i class="fa fa-pencil-square-o"></i></a> <a href="task/delete.php?task_id=<?php echo $finishedTask['id']; ?>">
                    <i class="fa fa-ban"></i>
                   </a>
                 </span>
                </div>
              <?php }?>
            </ul>
          </div>
          <?php  if (isset($_SESSION['category_id'])) { ?>
            <input type="hidden" name="category_id" value="<?php echo $_SESSION['category_id']; ?>">
          <?php } ?>
          <input type="submit" value="チェックしたタスクを完了にする">
        </form>
      </div>

    </div>
    <!-- メイン部分終了 -->
  <!-- 第1コンテナ終了 -->
  </div>

  <!-- フッター用コンテナ -->
  <div  class="container">
    <div class="row">
      <!-- フッターパート -->
    </div>
  </div>