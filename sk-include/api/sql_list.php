<?php
$table = $_GET['table'];
$limit = $_GET['limit'];
if ($table == 'sk_user') {
    $id = 'uid';
} else if ($table == 'sk_content') {
    $id = 'cid';
}
function getConn()
{
    $sql = new sql;
    $sql->sql_config();
    // 数据库MySQLi
    // 创建连接
    $conn = mysqli_connect($sql->sql_location, $sql->sql_user, $sql->sql_pwd, $sql->sql_name);
    // 检测连接
    if (!$conn) {
        die("连接失败: " . mysqli_connect_error());
    }
    return $conn;
}
// 查询数据库记录总数
$res = mysqli_query(getConn(), "select * from $table");
$count = mysqli_fetch_row($res);
$count = $count[0];
if ($count == null) {
    ob_clean();
    $query_result = null;
    $c = null;
    echo json_encode(array('code' => 0, 'count' => $c, 'data' => $query_result), JSON_UNESCAPED_UNICODE);
    exit;
} else {
    // 设置最大页数
    $max_page = ceil($count / $limit);
    // 初始化页数
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $page = $page > $max_page ? $max_page : $page;
    $page = $page < 1 ? 1 : $page;
    // 每次起始查找位置
    $lim = ($page - 1) * $limit;
    // 每次查询从第$lim条开始，查询$pageSize条
    $result_ = mysqli_query(getConn(), "select * from $table order by $id limit {$lim}, {$limit}");
    $query_result = array();
    $i = 0;
    // 将结果存放到$query_result
    if (mysqli_num_rows($result_) > 0) {
        while ($row = mysqli_fetch_assoc($result_)) {
            $query_result[$i] = $row;
            $i++;
        }
        $c = mysqli_num_rows($res);
        ob_clean();
        echo json_encode(array('code' => 0, 'count' => $c, 'data' => $query_result), JSON_UNESCAPED_UNICODE);
    }
}
