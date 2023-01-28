<?php
include_once 'sk-include/function/common.php';

$get_action = $_GET['action'];
$require = 'sk-include/api/' . $get_action . '.php';
if (file_exists($require)) {
    $api_code = "0";
    $api_msg = "请求成功";
    include 'sk-include/api/' . $get_action . '.php';
} else if ($get_action==null){
    header('HTTP/1.0 403');
    exit;
} else {
    include 'sk-include/template/404.php';
}

exit;