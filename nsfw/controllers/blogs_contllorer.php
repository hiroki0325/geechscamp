<?php
    // データなどを処理する(controller)
    while ($resource = mysqli_fetch_assoc($resorces)) {
      $title = $resource['title'];
      $created = $resource['created'];
    }
?>
