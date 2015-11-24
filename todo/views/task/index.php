<?php
    $tasksController = new tasksController($db, $plural_resorce);
    // ToDo 返り値をまとめて受け取らなければならない説
    $tasks = $tasksController->index();
    $user = $tasks[0];
    $unfinishedTasks = $tasks[1];
    $finishedTasks = $tasks[2];
    $myCategories = $tasks[3];
?>

<div class="container">

  <!-- 1行目 -->
  <div class="row">

    <!-- カテゴリパート -->
    <div class="col-sm-3" style="text-align: center;">
      こんにちは、<?php echo $user['name']; ?>さん
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
              <a href="index">
                <i class="fa fa-folder-open-o"></i>タスク一覧
              </a><br>
            </h4>
          </div>

          <!-- カテゴリ一覧を表示 -->
          <div id="collapseOne" class="panel-collapse collapse in">
            <div class="panel-body">
              <table class="table">
                <?php while ($myCategory = mysqli_fetch_assoc($myCategories)) { ?>
                  <tr>
                    <td>
                      <a href="index?category_id=<?php echo $myCategory['id']; ?>">
                        <i class="fa fa-file-text-o"></i>
                        <?php  echo $myCategory['name']; ?>
                      </a>
                      <?php $taskNum = cnt($db, $myCategory);?>
                      <?php if($taskNum['cnt'] != 0){ ?>
                        <span class="badge">
                          <?php echo $taskNum['cnt']; ?>
                        </span>
                      <?php } ?>
                      <span style="float: right">
                        <a href="index?action=edit&category_id=<?php echo $myCategory['id']; ?>">
                          <i class="fa fa-pencil-square-o"></i>
                        </a>
                        <a href="../category/delete?category_id=<?php echo $myCategory['id']; ?>">
                          <i class="fa fa-ban"></i>
                        </a>
                      </span>
                      <br>
                      <?php if (isset($_REQUEST['action']) && isset($_REQUEST['category_id'] )): ?>
                        <?php if ($_REQUEST['action']=='edit' && $_REQUEST['category_id'] == $myCategory['id']): ?>
                          <form action="../category/update" method="post">
                            <input type="text" name="edited_categoryname" style="width:180px;" placeholder="変更後のカテゴリ名">
                            <?php  if (isset($_SESSION['category_id'])) { ?>
                            <input type="hidden" name="category_id" value="<?php echo $_SESSION['category_id']; ?>">
                            <?php }?>
                            <input type="submit" value="変更" style="float: right">
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
              <form action="../category/create" method="post" accept-charset="utf-8">
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
      <form action="create" method="POST" accept-charset="utf-8">
        <div class="col-sm-10">
          <span style="float: left;">
            <input type="text" name="task_title" placeholder="新しいToDoを入力" class="form-control add-todo" style="margin: 0px 0px 0px -15px; width: 445px;">
          </span>
          <span style="float: right;">
            <select name="category_id" style="height: 25px; font-size: 30px; margin-top: 2px; ">
              <option value="">カテゴリを選択してください</option>
              <?php mysqli_data_seek($myCategories, 0); ?>
              <?php while ($myCategory = mysqli_fetch_assoc($myCategories)) { ?>
                <option value="<?php echo $myCategory['id'] ?>"><?php echo $myCategory['name'] ?></option>
              <?php } ?>
            </select>
          </span>
        </div>
        <div class="col-sm-2">
          <button type="submit" class="btn btn-success">ToDoを追加する</button>
        </div>
      </form>
    </div>

    <!-- 既存タスクセクション -->
    <div class="col-xs-9">
      <form action="finish" method="post" accept-charset="utf-8">

        <!-- 未完了タスク -->
        <hr>
        <div class="todolist not-done">
          <ul id="sortable" class="list-unstyled">
            <?php while ($unfinishedTask = mysqli_fetch_assoc($unfinishedTasks)) { ?>
              <div class="checkbox" style="border-bottom:1px solid #ddd;">
                <li class="ui-state-default">
                  <input type="checkbox" name="<?php echo $unfinishedTask['id'] ?>" value="finish">

                  <?php if( $unfinishedTask['deadline'] !='' &&$unfinishedTask['deadline'] < date('Y-m-d')){ ?>
                    <span  style="color: #ff0000; ">
                      <?php  echo $unfinishedTask['title']; ?>
                      <i class="fa fa-exclamation-triangle"></i>
                    </span>
                  <?php }else{ ?>
                    <span>
                      <?php  echo $unfinishedTask['title']; ?>
                    </span>
                  <?php } ?>
                </li>
                <span style="float: right">
                  <?php if(!empty($unfinishedTask['deadline'])){ ?>
                    <span class="deadline">
                      期限：
                      <?php echo $unfinishedTask['deadline'] ?>
                    </span>
                  <?php } ?>
                  <a href="task/update?task_id=<?php echo $unfinishedTask['id']; ?>">
                    <i class="fa fa-pencil-square-o"></i>
                  </a>
                  <a href="task/delete?task_id=<?php echo $unfinishedTask['id']; ?>">
                    <i class="fa fa-ban"></i>
                  </a>
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
                  <a href="task/update?task_id=<?php echo $finishedTask['id']; ?>"><i class="fa fa-pencil-square-o"></i></a> <a href="task/delete?task_id=<?php echo $finishedTask['id']; ?>">
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
