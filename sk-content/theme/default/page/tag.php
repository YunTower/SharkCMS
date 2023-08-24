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
            <div class="animated fadeInDown m-[30px] mt-[20px] border-b border-gray-200">
                <div class="flex flex-col pb-3">
                    <div class="flex flex-wrap items-end">
                        <h3 class="text-xl font-medium leading-6 text-gray-900">标签：<?= View::$vKey ?></h3>
                        <span class="ml-2 text-sm text-gray-500"><?php QueryCount('tag') ?> 篇文章</span>
                    </div>

                </div>
            </div>
            <div class="post animated fadeInDown">
                <?php foreach (View::query('tag') as $a) : ?>
                    <div class="post-title">
                        <h3 class="font-medium">
                            <a href="/page/article/<?= $a['cid'] ?>"><?= $a['title'] ?></a>
                        </h3>
                    </div>
                    <div class="post-content text-sm text-black/50">
                        <p class="py-2.5"><?= $a['content'] ?></p>
                    </div>
                    <div class="post-info border-b border-b-[#f2f2f2] pb-[30px]">
                        <div class="meta">
                            <div class="info">
                                <i class="i-mdi-calendar-month-outline h-3 w-3"></i>
                                <span><?= $a['created'] ?></span>
                                <i class="i-mdi-eye h-3 w-3"></i>
                                <span>3</span>
                                <i class="i-mdi-comment-outline h-3 w-3"></i>
                                <a>0</a>
                                <i class="i-mdi-folder-outline h-3 w-3"></i>
                                <a href="/page/category/<?= $a['category'] ?>" title="<?= $a['category'] ?>"><?= $a['category'] ?></a>
                                <i class="i-mdi-tag h-3 w-3"></i>
                                <a href="/page/tags/<?= $a['tag'] ?>" title="<?= $a['tag'] ?>"><?= $a['tag'] ?></a>

                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

        </div>
    </div>

    <?php View::get_footer() ?>
</body>

</html>