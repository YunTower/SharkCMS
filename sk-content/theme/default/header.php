<?php

use FrameWork\FrameWork;
use FrameWork\View\View as View;

?>
<link rel="icon" href="<?= FrameWork::$getSetting['Site-Logo'] ?>">
<style>
  .sidebar {
    width: 40%;
  }

  .page-top {
    width: calc(100% - 40%);
  }

  .content {
    width: calc(100% - 40%);
  }

  .link {
    color: #2d8cf0;
  }

  .link:hover {
    color: #2d8cf0;
    text-decoration: underline;
  }
</style>
<link rel="stylesheet" href="<?php View::static('static/css/style.css?v=2.1.0') ?>" />