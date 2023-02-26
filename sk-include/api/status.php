<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    exit;
} else {
    ob_clean();
    $json = base64_decode(md5_decrypt(($_SESSION['user_token']), 'sharkcms-user-token'));
    $arr = json_decode($json, true);
    $uid = $arr['uid'];
    $sql = new sql;
    $sql->sql_config();
    try {
        $conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "select * from `sk_user` where uid='$uid'";
        $res = $conn->query($sql);
        foreach ($res as $row) {
            if (date('YmdHi') - $row['logintime'] > 199) {
                echo json_encode(array('msg' => '登陆失效', 'login' => false), JSON_UNESCAPED_UNICODE);
                unset($_SESSION['user_token']);
                unset($_COOKIE['user_token']);
            } else {
                echo json_encode(array('msg' => '登陆正常', 'login' => true), JSON_UNESCAPED_UNICODE);
            }
        }
    } catch (PDOException $e) {
        echo json_encode(array('code' => 0, 'msg' => '数据库查询失败，错误代码：' . $e->getMessage()), JSON_UNESCAPED_UNICODE);
    }
    exit;
}
