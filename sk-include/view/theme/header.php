<?php

use FrameWork\Main as FrameWork;
use FrameWork\View\View;
use FrameWork\Hook\Hook;

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>
    <?php if (View::$vTitle) {
        echo View::$vTitle;
    } else {
        echo FrameWork::$getSetting['Site-Title'] . ' - ' . FrameWork::$getSetting['Site-Subtitle'];
    } ?>
</title>
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />
<meta name="renderer" content="webkit" />
<meta name="keywords" content="<?= FrameWork::$getSetting['Seo-Keyword'] ?>" />
<meta name="description" content="<?= FrameWork::$getSetting['Seo-Description'] ?>" />
<?php include_once vPath . 'header.php'; ?>
<?= Hook::add('theme-header', ''); ?>
<?= FrameWork::$getSetting['Site-HeaderCode'] ?>