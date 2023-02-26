<?php
// function get_header(){
//     include "sk-content/theme/default/header.php";
// }

function import_file($file)
{
    include "sk-content/theme/" . set_theme() . '/' . $file;
}

function get_title()
{
    return "fish"; //测试数据
}

function get_nexttitle()
{
    return "SharkCMS演示站"; //测试数据
}

function import_logo($file_link)
{
    return sys_domain() . "/sk-content/upload/" . $file_link;
}

function import_static($file_link)
{
    return sys_domain() . "/sk-content/theme/" . set_theme() . "/" . $file_link;
}

function get_link()
{
    return sys_domain() . '/s/';
}

function post_get_list()
{
    $db = new DB;
    $db->db_config();
    try {
        $conn = new PDO("mysql:dbname=$db->db_name;host=$db->db_location", $db->db_user, $db->db_pwd);
    } catch (PDOException $e) {
        sys_error('数据库错误', '数据库连接失败，错误代码：' . $e->getMessage());
    }
    $sql = "select * from sk_content order by cid desc"; //降序排列
    $res = $conn->query($sql);
    foreach ($res as $row) {
        if ($row['cid'] == null) {
            echo '<a style="marign:20px">查询失败，数据为空</a>';
        } else {
            echo '<div class="sharkcms-post"><div class="sharkcms-post-title">';
            echo '<h3><a href="index.php/page/article?cid=' . $row['cid'] . '">' . $row["title"] . '</a></h3>';
            echo '</div><div class="sharkcms-post-content">';
            echo '<p>';
            post_get_introduction($row['cid']);
            echo '</p>';
            echo '</div><div class="sharkcms-post-footer">';
            echo '<ul class="sharkcms-post-meta"><li class="first">作者：<a href="/index.php/page/user?uid=' . $row['uid'] . '">';
            
            $db->db_read('sk_user', 'name', 'uid', $row['uid']);

            echo '</a></li><li>发布于' . $row['created'] . '</li></ul></div></div>';
        }
    }
}

function post_get_post($cid)
{
    $db = new DB;
    $db->db_config();
    $db->db_read('sk_content', 'content', 'cid', "$cid");
}

function post_get_introduction($cid)
{
    $db = new DB;
    $db->db_config();
    $db->db_read('sk_content', 'introduction', 'cid', "$cid");
}

function post_get_title($cid)
{
    $db = new DB;
    $db->db_config();
    $db->db_read('sk_content', 'title', 'cid', "$cid");
}

function post_get_time($cid)
{
    $db = new DB;
    $db->db_config();
    $db->db_read('sk_content', 'created', 'cid', "$cid");
}

function post_get_uid($cid)
{
    $db = new DB;
    $db->db_config();
    $db->db_read('sk_content', 'uid', 'cid', "$cid");
}

function post_get_author($cid)
{
    $db = new DB;
    $db->db_config();
    try {
        $conn = new PDO("mysql:dbname=$db->db_name;host=$db->db_location", $db->db_user, $db->db_pwd);
    } catch (PDOException $e) {
        sys_error('数据库错误', '数据库连接失败，错误代码：' . $e->getMessage());
    }
    $sql = "select uid from sk_content where cid=$cid";
    $res = $conn->query($sql);
    foreach ($res as $row) {
        $uid = $row['uid'];
        $sql = new sql;
        $sql->sql_config();
        $sql->sql_read('sk_user', 'name', 'uid', $uid);
    }
}
