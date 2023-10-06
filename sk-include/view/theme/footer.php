<?php

use FrameWork\Main as FrameWork;
use FrameWork\Hook\Hook;

?>
<script src="<?php echo FrameWork::getDomain() ?>/sk-include/static/js/axios.min.js"></script>
<script src="<?php echo FrameWork::getDomain() ?>/sk-include/static/js/sharkcms.min.js"></script>
<?= Hook::add('theme-footer', ''); ?>
<?php include_once vPath . 'footer.php'; ?>

<?= FrameWork::$getSetting['Site-FooterCode'] ?>

