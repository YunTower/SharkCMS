<?php
$get_json = file_get_contents("php://input");

// 解析数据
$arr = json_decode($get_json, true);
$post_user = $arr['user'];
$post_pwd = $arr['pwd'];

// 转换格式
$user = urlencode($post_user);
$pwd = $post_pwd;
// 匹配数据库用户信息
$data = file_get_contents(INC . 'config.json');
$arr = json_decode($data, true);
$sql_location = $arr['sql_location'];
$sql_name = $arr['sql_name'];
$sql_user = $arr['sql_user'];
$sql_pwd = $arr['sql_pwd'];
try {
    $conn = new PDO("mysql:dbname=$sql_name;host=$sql_location", $sql_user, $sql_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select uid from sk_user where name='$user'";
    $res = $conn->query($sql);
    foreach ($res as $row) {
        if($row['uid']==null){
            echo '查询失败';
        } else{
            $serve = file_get_contents('http://127.0.0.1:88/update.php?v='.$user_v . '&domain='.$user_domain);
    $serve_back = json_decode($serve, true);
    $back_msg= $serve_back['msg'];
        }
        
    }
} catch (PDOException $e) {
    sys_error('数据库错误', '错误代码：' . $e->getMessage());
}