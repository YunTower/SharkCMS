<?php
Theme::import('header.php');
Theme::import('home_left.php');
Theme::import('home_nav.php'); ?>

<div class="right">
    <div class="content">
        <?php Theme::PageContent() ?>
    </div>
</div>

<?php Theme::import('footer.php'); ?>