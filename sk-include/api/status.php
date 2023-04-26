<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(array('code' => 0, 'msg' => '请求不合规！'), JSON_UNESCAPED_UNICODE);
} else {
    $json = base64_decode(md5_decrypt(($_SESSION['user_token']), 'sharkcms-user-token'));
    $arr = json_decode($json, true);
    $sql = json_encode(array('name' => 'sk_user', 'id' => '*', 'whereid' => 'uid', 'whereinfo' => $arr['uid']));
    foreach (DBread('EchoWHERE', $sql) as $row) {
        if (date('YmdHi') - $row['logintime'] > 200 || date('YmdHi') - $row['logintime'] > 10000) {
            echo json_encode(array('msg' => '登陆失效', 'login' => false), JSON_UNESCAPED_UNICODE);
            unset($_SESSION['user_token']);
            unset($_COOKIE['user_token']);
        } else {
            echo json_encode(array('msg' => '登陆正常', 'login' => true), JSON_UNESCAPED_UNICODE);
        }
    }
}
