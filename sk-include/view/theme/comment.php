<div class="sk-comment">
    <div class="sk-input">
        <textarea id="sk-comment" placeholder="攥写评论"></textarea>
    </div>
    <div class="sk-btn">
        <?php
        if (User::$loginStatus) {
            $info = User::$userInfo;
            echo '<span class="sk-comment-user">' . $info['mail'] . '</span>';
            echo '<span class="sk-comment-user" onclick="sk.loginOut()">[退出]</span>';
        } else {
            echo '<span class="sk-user"><a onclick="sk.login()">[登陆]</a></span>';
        }
        ?>
        <button class="sk-send" onclick="sk_comment_send()">提交评论</button>
    </div>
    <div class="sk-comment-list">
        <ul>
            <?php
            foreach (View::getComment(FrameWork::getData()) as $d):?>

                <li id="#comment-<?=$d['id']?>">
                    <img class="sk-comment-avatar" src="<?=$d['user']['avatar']?>"/>
                    <div class="sk-comment-details">
                        <div class="sk-comment-info">
                            <span class="sk-comment-uname"><<?= $d['user']['name'] ?></span>
                            <span class="sk-comment-time"><?= $d['created']?></span>
                        </div>
                        <span class="sk-comment-ucomment"><?=$d['content']?></span>
                        <div class="sk-comment-reply" onclick="sk_comment_reply()">
                            <span>[回复]</span>
                        </div>
                    </div>

                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</div>
