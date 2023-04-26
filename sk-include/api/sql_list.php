<?php
$table = $_GET['table'];
$limit = $_GET['limit'];
$order = $_GET['order'];

if ($table == 'sk_user') {
    $id = 'uid';
} else if ($table == 'sk_content') {
    $id = 'cid';
}
$sql = json_encode(array('name' => $_GET['table'], 'id' => '*'));

$count = DBread('EchoSize', $sql);
// 设置最大页数
$max_page = ceil($count / $limit);
// 初始化页数
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = $page > $max_page ? $max_page : $page;
$page = $page < 1 ? 1 : $page;
// 每次起始查找位置
$lim = ($page - 1) * $limit;
// 每次查询从第$lim条开始，查询$pageSize条
$result_ = mysqli_query(DBconnect(), "select * from $table order by $id " . $_GET['order'] . " limit {$lim}, {$limit}");
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
