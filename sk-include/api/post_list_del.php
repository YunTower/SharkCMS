<?php

$del=$_GET['del'];
$sql=new sql;
$sql->sql_config();
try {
    $conn = new PDO("mysql:dbname=$sql->sql_name;host=$sql->sql_location", $sql->sql_user, $sql->sql_pwd);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "delete from sk_content where cid=$del";
    $conn->exec($sql);
    $arr = array('msg' => '删除成功','status'=>'ok');
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
} catch (PDOException $e) {
    $arr = array('msg' => '删除失败','status'=>'');
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
}