<?php
$get_title = $_POST['post_title'];
$get_introduction = $_POST['post_introduction'];
$get_content = urlencode($_POST['post_content']);
$get_cover = $_POST['post_cover'];
$get_pwd = $_POST['post_pwd'];
$get_order = $_POST['post_order'];
if ($get_title != null && $get_content != null) {
    // 如果标题超过40个字符
    if (strlen($get_title) > 40) {
        exit($json = json_encode(array('msg' => '标题长度超过40个字符！', 'status' => ''), JSON_UNESCAPED_UNICODE));
    } else {
        // 如果简介超过50个字符
        if (strlen($get_introduction) > 150) {
            exit($json = json_encode(array('msg' => '简介长度超过150个字符！', 'status' => ''), JSON_UNESCAPED_UNICODE));
        } else {
            $sql = new sql;
            $sql->sql_config();
            $sql->sql_write('sk_content', '`title`,`introduction`,`content`,`order`,`uid`', "'$get_title','$get_introduction','$get_content','$get_order','1'");
            exit($json = json_encode(array('msg' => '文章发布成功！', 'status' => 'ok'), JSON_UNESCAPED_UNICODE));
        }
    }
} else {
    exit($json = json_encode(array('msg' => '文章标题和文章内容不能为空！'), JSON_UNESCAPED_UNICODE));
}
