<div class="right">
    <div class="content">

        <? foreach (DBread('EchoALL', json_encode(array('name' => 'sk_content', 'id' => '*'))) as $row) : ?>
            <div class="sharkcms-post">
                <div class="sharkcms-post-title">
                    <h3><a href="<? echo Route::Domain() ?>/index.php/page/post/<? echo $row['cid'] ?>"><? echo $row["title"] ?></a></h3>
                </div>
                <div class="sharkcms-post-content">
                    <p>
                        <? echo $row['content']; ?>
                    </p>
                </div>
                <div class="sharkcms-post-footer">
                    <ul class="sharkcms-post-meta">
                        <li class="first">作者：<a href="<? echo Route::Domain() ?>/index.php/page/user/<? echo $row['uid'] ?>">
                                <? echo $row['name']; ?>
                            </a>
                        </li>
                        <li>发布于<? echo $row['created'] ?></li>
                    </ul>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>