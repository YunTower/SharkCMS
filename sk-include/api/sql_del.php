<?php
$del = $_GET['del'];
$table = $_GET['table'];
if ($table == 'sk_user') {
    $id = 'uid';
    if ($table == 'sk_user' && $del == '1') {
        echo json_encode(array('msg' => '删除失败，你没有权限删除此用户'), JSON_UNESCAPED_UNICODE);
        exit;
    }
} else if ($table == 'sk_content') {
    $id = 'cid';
}
$sql = new sql;
$sql->sql_config();
try {
    $conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "delete from $table where $id=$del";
    $conn->exec($sql);
    exit($json = json_encode(array('msg' => '删除成功', 'status' => 'ok'), JSON_UNESCAPED_UNICODE));
} catch (PDOException $e) {
    exit($json = json_encode(array('msg' => '删除失败' . $e->getMessage(), 'status' => ''), JSON_UNESCAPED_UNICODE));
}
