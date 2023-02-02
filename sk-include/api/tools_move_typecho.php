<?php
$get_location = $_GET['location'];
$get_name = $_GET['name'];
$get_user = $_GET['user'];
$get_pwd = $_GET['pwd'];
try {
    $conn = new PDO("mysql:dbname=$get_name;host=$get_location", $get_user, $get_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from rapidcmspage";
    $res = $conn->query($sql);
    foreach ($res as $row) {
        $data = file_get_contents('../../sk-include/config.json');    // 获取数据
        $arr = json_decode($data, true);    // 将获取到的 JSON 数据解析成数组
        $location = $arr['sql_location'];
        $name = $arr['sql_name'];
        $user = $arr['sql_user'];
        $pwd = $arr['sql_pwd'];
        try {
            $conn = new PDO("mysql:dbname=$name;host=$location", $user, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (!$conn) {
                $arr = array('msg' => '迁移失败！', 'status' => '', 'error' => $e->getMessage());
                $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
                echo $json;
            }
            $m_title = $row['title'];
            $m_content = $row['content'];
            $sql = "insert into sk_content (title,content,uid) values ('$m_title','$m_content','admin')";
            $conn->exec($sql);
            $arr = array('msg' => '文章迁移成功！', 'status' => 'ok');
            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $json;
        } catch (PDOException $e) {
            $arr = array('msg' => '迁移失败！', 'status' => '', 'error' => $e->getMessage());
            $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }
} catch (PDOException $e) {
    $arr = array('msg' => '迁移失败！', 'status' => '', 'error' => $e->getMessage());
    $json = json_encode($arr, JSON_UNESCAPED_UNICODE);
    echo $json;
}
