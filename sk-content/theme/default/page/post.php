<?php
Theme::import('header.php');
Theme::import('home_left.php');
Theme::import('home_nav.php');
?>

<div class="right">
    <div class="content">
        <? if (!is_numeric(Route::getData())) {
            sys_error('请求错误', '请求中包含非法字符或请求不完整！');
        } else {
            foreach (DBread('EchoWHERE', json_encode(array('name' => 'sk_content', 'id' => '*', 'whereid' => 'cid', 'whereinfo' => Route::getData()))) as $row) :
        ?>
                <!-- 文章框架 -->
                <div class="sharkcms-post">
                    <!-- 文章头部 -->
                    <div class="sharkcms-post-header">
                        <!-- 标题 -->
                        <div class="sharkcms-post-title">
                            <h3>
                                <? echo $row['title']; ?>
                            </h3>
                        </div>
                        <!-- 信息栏 -->
                        <ul class="sharkcms-post-meta">
                            <li class="first">作者：
                                <a href="/index.php/page/user/<? echo $row['uid']; ?>">
                                    <? echo $row['name']; ?>
                                </a>
                            </li>
                            <!-- 发布时间 -->
                            <li>
                                发布于
                                <? echo $row['created']; ?>
                            </li>
                        </ul>
                    </div>
                    <!-- 文章主题 -->
                    <div class="sharkcms-post-body">
                        <div class="sharkcms-post-content">
                            <? echo $row['content']; ?>
                        </div>
                    </div>
                    <!-- 文章底部 -->
                    <div class="sharkcms-post-footer">
                        <p style="font-size: 10px;">待开发</p>
                    </div>
            <?php endforeach;
        } ?>
                </div>
    </div>

    <?php Theme::import('footer.php'); ?>