<?php
    // BlogsControllerのindexを呼び出す
    $BlogsController = new BlogsController($db, $plural_resorce);
    $blogs = $BlogsController->index();

?>
<h2>記事一覧</h2>
<div>
  <!-- <a href="new">記事作成</a> -->
  <?php echo link_to("new","記事作成"); ?>
</div>
<?php while($blog = mysqli_fetch_assoc($blogs)): ?>
  <ul>
    <li><?php echo $blog['title'] ?> : 【<?php echo link_to('show/'.$blog['id'],'詳細'); ?>】</li>
  </ul>
<?php endwhile; ?>
