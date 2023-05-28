<div class="right">
    <div class="content">

        <? foreach (Theme::getPostList() as $row)  : ?>
            <div class="sharkcms-post">
                <div class="sharkcms-post-title">
                    <h3><a href="<? echo Route::Domain() ?>/page/post/<? echo $row['cid'] ?>"><? echo $row['title'] ?></a></h3>
                </div>
                <div class="sharkcms-post-content">
                    <p>
                        <? echo $row['content']; ?>
                    </p>
                </div>
                <div class="sharkcms-post-footer">
                    <ul class="sharkcms-post-meta">
                        <li class="first">作者：<a href="<? echo Route::Domain() ?>/page/user/<? echo $row['uid'] ?>">
                                <? echo $row['name'] ?>
                            </a>
                        </li>
                        <li>发布于<? echo $row['created'] ?></li>
                    </ul>
                </div>
            </div>
        <? endforeach;unset($row); ?>
    </div>
</div>