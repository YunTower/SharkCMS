<?php
$sql = new sql;
$sql->sql_config();
try {
    $conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select title,introduction,uid,corder,created from sk_content";
    $res = $conn->query($sql);
    if ($query = $conn->query($sql)) {
        $a = json_decode(stripslashes(json_encode($query->fetchAll(PDO::FETCH_ASSOC), JSON_UNESCAPED_UNICODE)), true);
        $count = $res->rowCount();
        $arr = array('code' => 0, 'msg' => '查询成功', 'count' => $count, 'data' => $a);
        $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
        echo $json;
    }
} catch (PDOException $e) {
    $arr = array('code' => 0, 'msg' => '数据库查询失败');
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
}
