<?php
header('Access-Control-Allow-Origin:*');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 获取json数据
    $get_json = file_get_contents("php://input");

    // 解析数据
    $arr = json_decode($get_json, true);
    $user_v = $arr['v'];
    $user_domain = $arr['domain'];
    


    $serve = file_get_contents('http://127.0.0.1:88/update.php?v='.$user_v . '&domain='.$user_domain);
    $serve_back = json_decode($serve, true);
    $back_msg= $serve_back['msg'];

    $arr = array('msg' => $back_msg);
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
}
