<?php
    $usersController = new usersController($db, $plural_resorce);
    $error = $usersController->_new();
?>

  <p>次のフォームに必要事項をご記入ください。</p>
  <form action="" method="post">
      <dl>
          <dt>ニックネーム<span class="required">必須</span></dt>
          <dd>
            <?php fillout("name"); ?>
            <?php if (isset($error['name'])): ?>
                <?php if ($error['name'] == 'blank') : ?>
                  <p class="error">* ニックネームを入力してください</p>
                <?php endif ; ?>
                <?php if ($error['name'] == 'duplicate'): ?>
                  <p class="error">* 指定されたニックネームはすでに使用されています</p>
                <?php endif ?>
            <?php endif ; ?>
          </dd>
          <dt>パスワード<span class="required">必須</span></dt>
          <dd>
            <input type="password" name="password" size="10" maxlength="20">
            <?php if (isset($error['password'])): ?>
              <?php if ($error['password'] == 'blank') : ?>
              <p class="error">* パスワードを入力してください</p>
              <?php endif ; ?>
              <?php if ($error['password'] == 'length') : ?>
              <p class="error">* パスワードは4文字以上で入力してください</p>
              <?php endif ; ?>
              <?php if ($error['password'] == 'notsame') : ?>
              <p class="error">* 入力されたパスワードが一致していません</p>
              <?php endif ; ?>
            <?php endif ; ?>
          </dd>
          <dt>パスワード(再入力)<span class="required">必須</span></dt>
          <dd>
            <input type="password" name="password2" size="10" maxlength="20">
          </dd>
        </dl>
        <div><input type="submit" value="入力内容を確認する"></div>
  </form>
