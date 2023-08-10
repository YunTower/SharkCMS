<div class="sk-comment">
    <div class="sk-input">
        <textarea id="sk-comment" placeholder="攥写评论"></textarea>
    </div>
    <div class="sk-btn">
        <?php
        if (isset($_SESSION['token'])) {
            $uid = json_decode(base64_decode($_SESSION['token']))->uid;
            $info = self::$_user->info($uid);
            echo '<span class="sk-user">' . $info['mail'] . '</span>';
            echo '<span class="sk-user" onclick="sk.loginOut()">[退出]</span>';
        } else {
            echo '<span class="sk-user"><a onclick="sk.login()">[登陆]</a></span>';
        }
        ?>
        <button class="sk-send" onclick="sk_comment_send()">提交评论</button>
    </div>
    <div class="sk-comment-list">
        <ul>
            <li>
                <img class="sk-comment-avatar" src="http://127.0.0.1/sk-content/upload/avatar/default.webp" />
                <div class="sk-comment-details">
                    <div class="sk-comment-info">
                        <span class="sk-comment-uname">fish</span>
                        <span class="sk-comment-time">2023-7-29 21:03</span>
                    </div>
                    <span class="sk-comment-ucomment">这是一条评论</span>
                    <div class="sk-comment-reply" onclick="sk_comment_reply()">
                        <span>[回复]</span>
                    </div>
                </div>

            </li>
            <li>
                <img class="sk-comment-avatar" src="http://127.0.0.1/sk-content/upload/avatar/default.webp" />
                <div class="sk-comment-details">
                    <div class="sk-comment-info">
                        <span class="sk-comment-uname">fish</span>
                        <span class="sk-comment-time">2023-7-29 21:03</span>
                    </div>
                    <span class="sk-comment-ucomment">这是一条评论</span>
                    <div class="sk-comment-reply" onclick="sk_comment_reply()">
                        <span>[回复]</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>
