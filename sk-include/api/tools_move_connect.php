<?php
$get_location=$_GET['location'];
$get_name=$_GET['name'];
$get_user=$_GET['user'];
$get_pwd=$_GET['pwd'];
try {
    $conn = new PDO("mysql:dbname=$get_name;host=$get_location", $get_user, $get_pwd);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!$conn) {
        die('数据库错误，数据库连接失败，错误代码：' . mysqli_connect_error());
    }
} catch (PDOException $e) {
    echo '数据库错误', '数据库连接失败，错误代码：' . $e->getMessage();
}