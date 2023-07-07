<!DOCTYPE html>
<html lang="zh">

<head>
    <?php View::get_header() ?>
</head>

<body>
    <?php View::get_sidebar() ?>

    <div class="main">
        <?php View::include('menu.php') ?>
        <?php $data = self::$vArticle ?>
        <div class="content">
            <div class="animated fadeInDown m-[30px] mt-[20px] border-b border-gray-200">
                <div class="flex flex-col pb-3">
                    <div class="flex flex-wrap items-end">
                        <h3 class="text-xl font-medium leading-6 text-gray-900"><?php echo $data['title'] ?></h3>
                    </div>
                    <div class="post-info mt-2">
                        <div class="meta">
                            <div class="info">
                                <i class="i-mdi-calendar-month-outline h-3 w-3"></i>
                                <span>2023-07-06</span>
                                <i class="i-mdi-eye h-3 w-3"></i>
                                <span>2</span>
                                <i class="i-mdi-comment-outline h-3 w-3"></i>
                                <a href="#comment">0</a>
                                <i class="i-mdi-folder-outline h-3 w-3"></i>
                                <a href="/page/category/default" title="默认分类">默认分类</a>
                                <i class="i-mdi-tag h-3 w-3"></i>
                                <a href="/page/tag/SharkCMS" title="Halo">Halo</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="post-page">
                <div class="post animated fadeInDown">
                    <div id="post-content" class="post-content markdown-body">
                        <?php echo $data['content'] ?>
                    </div>
                </div>
                <div class="pagination flex items-center justify-between">


                </div>
                <?php //View::get_comment() 
                ?>
            </div>

        </div>
    </div>
</body>

</html>