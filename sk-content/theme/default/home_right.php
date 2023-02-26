<div class="right">
    <div class="content">
    
        <? foreach ($db->db_read('sk_user', '*') as $row) { ?>
        <div class="sharkcms-post">
            <div class="sharkcms-post-title">
                <h3><a href="index.php/page/article?cid=<?php $row['cid'] ?>">' . $row["title"] . '</a></h3>
            </div>
            <div class="sharkcms-post-content">
                <p>
                   <? post_get_introduction($row['cid']);?>
                </p>
            </div>
            <div class="sharkcms-post-footer">
                <ul class="sharkcms-post-meta">
                    <li class="first">作者：<a href="/index.php/page/user?uid=<? $row['uid'] ?>">

                            <? $db->db_read('sk_user', 'name', 'uid', $row['uid']);?>

                        </a></li>
                    <li>发布于<? $row['created'] ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>