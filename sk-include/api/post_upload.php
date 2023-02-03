<?php
$get_title = $_POST['post_title'];
$get_introduction = $_POST['post_introduction'];
$get_content = urlencode($_POST['post_content']);
$get_cover = $_POST['post_cover'];
$get_pwd = $_POST['post_pwd'];
$get_corder = $_POST['post_corder'];
if ($get_title != null && $get_content != null) {
    // 如果简介为空
    if ($get_introduction == null) {
        // 截取内容
        $content = strip_tags($_POST['post_content']);
        $introduction_50 = substr($content, 0, 50);
        // 判断长度
        if (strlen($get_title) > 40) {
            $arr = array('msg' => '标题长度超过40个字符！', 'status' => '');
            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            $sql = new sql;
            $sql->sql_config();
            $sql->sql_write('sk_content', 'title,introduction,content,corder,uid', "'$get_title','$introduction_50','$get_content','$get_corder','1'");
            $arr = array('msg' => '文章发布成功！', 'status' => 'ok');
            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    } else {
        // 如果标题超过40个字符
        if (strlen($get_title) > 40) {
            $arr = array('msg' => '标题长度超过40个字符！', 'status' => '');
            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $json;
        } else {
            // 如果简介超过50个字符
            if (strlen($get_introduction) > 50) {
                $arr = array('msg' => '简介长度超过50个字符！', 'status' => '');
                $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
                echo $json;
            } else {
                $sql = new sql;
                $sql->sql_config();
                $sql->sql_write('sk_content', 'title,introduction,content,corder,uid', "'$get_title','$get_introduction','$get_content','$get_corder','1'");
                $arr = array('msg' => '文章发布成功！', 'status' => 'ok');
                $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
                echo $json;
            }
        }
    }
} else {
    $arr = array('msg' => '文章标题和文章内容不能为空！');
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
    exit;
}
