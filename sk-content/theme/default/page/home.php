<!DOCTYPE html>
<html lang="zh">

<head>
    <?php View::get_header() ?>
</head>

<body>
    <?php View::get_sidebar() ?>

    <div class="main">
        <?php View::include('menu.php') ?>
        <div class="content">
            <?php foreach (View::query('article') as $a) : ?>
                <div class="post animated fadeInDown">
                    <div class="post-title">
                        <h3 class="font-medium">
                            <a href="/page/article/<?php echo $a['cid'] ?>"><?php echo $a['title'] ?></a>
                        </h3>
                    </div>
                    <div class="post-content text-sm text-black/50">
                        <p class="py-2.5"><?php echo $a['slug'] ?></p>
                    </div>
                    <div class="post-info border-b border-b-[#f2f2f2] pb-[30px]">
                        <div class="meta">
                            <div class="info">
                                <i class="i-mdi-calendar-month-outline h-3 w-3"></i>
                                <span><?php echo $a['created'] ?></span>
                                <i class="i-mdi-eye h-3 w-3"></i>
                                <span>0</span>
                                <i class="i-mdi-comment-outline h-3 w-3"></i>
                                <a>0</a>
                                <i class="i-mdi-folder-outline h-3 w-3"></i>
                                <a href="/page/category/<?php echo $a['category'] ?>" title="<?php echo $a['category'] ?>"><?php echo $a['category'] ?></a>
                                <i class="i-mdi-tag h-3 w-3"></i>
                                <a href="/page/tag/<?php echo $a['tag'] ?>/" title="<?php echo $a['tag'] ?>"><?php echo $a['tag'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php View::get_footer() ?>
</body>

</html>