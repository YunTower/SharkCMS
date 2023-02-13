<?php
$sql = new sql;
$sql->sql_config();

try {
    $conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $post = "select * from sk_content";
    $c_post = $conn->query($post)->rowCount();

    $page = "select * from sk_page";
    $c_page = $conn->query($page)->rowCount();

    $user = "select * from sk_user";
    $c_user = $conn->query($user)->rowCount();

    $count = json_encode(array('post' => $c_post, 'page' => $c_page, 'user' => $c_user, 'menu' => '0'), JSON_UNESCAPED_UNICODE);
    exit($json = json_encode(array('msg' => '查询成功！', 'domain' => sys_domain(), 'count' => ($count)), JSON_UNESCAPED_UNICODE));
} catch (PDOException $e) {
    exit($json = json_encode(array('msg' => '数据库连接失败，错误代码：' . $e->getMessage())));
}
