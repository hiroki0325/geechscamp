<?php
    // データなどを処理する(controller)
    while ($blog = mysqli_fetch_assoc($blogs)) {
      $title = $blog['title'];
      $created = $blog['created'];
    }
?>
