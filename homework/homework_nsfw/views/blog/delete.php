<?php

    // BlogsControllerのshowを呼び出す
    $BlogsController = new BlogsController($db, $plural_resorce, $option);
    $blogs = $BlogsController->delete();

?>
