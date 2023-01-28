<?php
import_file('header.php');
import_file('home_left.php');
import_file('home_nav.php'); ?>

<div class="right">
    <div class="content">
        <?php
        $cid = $_GET['cid'];
        $sql = new sql;
        $sql->sql_config();
        if (!is_numeric($cid)) {
            sys_error('请求错误', '请求中包含非法字符或请求不完整！');
        } else {
        ?>
            <!-- 文章框架 -->
            <div class="sharkcms-post">
                <!-- 文章头部 -->
                <div class="sharkcms-post-header">
                    <!-- 标题 -->
                    <div class="sharkcms-post-title">
                        <h3>
                            <?php post_get_title($cid); ?>
                        </h3>
                    </div>
                    <!-- 信息栏 -->
                    <ul class="sharkcms-post-meta">
                        <li class="first">作者：
                            <a href="/index.php/page/user?uid=<?php post_get_uid($cid); ?>">
                                <?php post_get_author($cid); ?>
                            </a>
                        </li>
                        <!-- 发布时间 -->
                        <li>
                            发布于
                            <?php post_get_time($cid); ?>
                        </li>
                    </ul>
                </div>
                <!-- 文章主题 -->
                <div class="sharkcms-post-body">
                    <div class="sharkcms-post-content">
                        <?php post_get_post($cid); ?>
                    </div>
                </div>
                <!-- 文章底部 -->
                <div class="sharkcms-post-footer">
                    <p style="font-size: 10px;">待开发</p>
                </div>
            <?php } ?>
            </div>
    </div>

    <?php import_file('footer.php'); ?>