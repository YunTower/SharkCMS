<?php
$title = $_POST['post_title'];
$introduction = $_POST['post_introduction'];
$content = urlencode($_POST['post_content']);
$cover = $_POST['post_cover'];
$pwd = $_POST['post_pwd'];
$power = $_POST['post_order'];

// 判断是否为空
if ($title != null || $content != null) {
    // 如果标题超过40个字符
    if (strlen($title) > 40) {
        exit(json_encode(array('msg' => '标题长度超过40个字符！', 'status' => ''), JSON_UNESCAPED_UNICODE));
    } else {
        // 如果简介超过50个字符
        if (strlen($introduction) > 150) {
            exit( json_encode(array('msg' => '简介长度超过150个字符！', 'status' => ''), JSON_UNESCAPED_UNICODE));
        } else {
            $sql = new sql;
            $sql->sql_config();
            $sql->sql_write('sk_content', '`title`,`introduction`,`content`,`cover`,`power`,`type`,`uid`', "'$title','$introduction','$content','$cover','$power','post','1'");
            exit(json_encode(array('msg' => '文章发布成功！', 'status' => 'ok'), JSON_UNESCAPED_UNICODE));
        }
    }
} else {
    exit(json_encode(array('msg' => '文章标题或文章内容不能为空！'), JSON_UNESCAPED_UNICODE));
}
