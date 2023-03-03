<div class="right">
    <div class="content">

        <? 
        // $sql_content = 'select * from sk_content';
        // $db_list_content = db_fetch(DB_ALL, $sql_content);
        // $db_data = array(
        //     'sk_content'=>$db_list_content,
        // );

        print_r($db_data['sk_content']);
        foreach ($db_data['sk_content'] as $row) : ?>
            <div class="sharkcms-post">
                <div class="sharkcms-post-title">
                    <h3><a href="index.php/page/article?cid=<? $row['cid'] ?>"><? $row["title"] ?></a></h3>
                </div>
                <div class="sharkcms-post-content">
                    <p>
                        <? $row['content']; ?>
                    </p>
                </div>
                <div class="sharkcms-post-footer">
                    <ul class="sharkcms-post-meta">
                        <li class="first">作者：<a href="/index.php/page/user?uid=<? $row['uid'] ?>">
                                <? //$row['name']; 
                                ?>
                            </a>
                        </li>
                        <li>发布于<? $row['created'] ?></li>
                    </ul>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>